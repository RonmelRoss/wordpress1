<?php

namespace DevOwl\RealCookieBanner\view;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\settings\Blocker as SettingsBlocker;
use DevOwl\RealCookieBanner\Utils;
use WP_Post;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Block inline `<script>`'s.
 */
class ScriptInlineBlocker {
    use UtilsProvider;
    /**
     * Inline scripts are completely different than usual URL scripts. We need to get
     * all available inline scripts, scrape their content and check if it needs to blocked.
     *
     * Available matches:
     *      $match[0] => Full string
     *      $match[1] => Attributes string after `<script`
     *      $match[2] => Full inline script
     *
     * @see https://regex101.com/r/7lYPHA/1/
     */
    const SCRIPT_INLINE_REGEXP = '/<script((?:(?!src=).)*?)>(.*?)<\\/script>/smix';
    // Also ported to `applyContentBlocker/listenOptIn.tsx`
    const HTML_ATTRIBUTE_INLINE = 'consent-inline';
    const HTML_TAG_CONSENT_SCRIPT = 'span';
    // use span, as wp_kses is intent to remove other custom tags, and we need an inline-tag
    /**
     * Singleton instance.
     *
     * @var ScriptInlineBlocker
     */
    private static $me = null;
    /**
     * C'tor.
     *
     * @codeCoverageIgnore
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Check if a given inline script is blocked.
     *
     * @param WP_Post[] $blockers
     * @param array $attributes
     * @param string $script
     */
    public function isBlocked($blockers, $attributes, $script) {
        $isBlocked = \false;
        $isJavascript = isset($attributes['type']) ? \strpos($attributes['type'], 'javascript') !== \false : \true;
        $isCdata =
            (isset($attributes['id'])
                ? \DevOwl\RealCookieBanner\Utils::endsWith($attributes['id'], '-js-extra')
                : \false) || \DevOwl\RealCookieBanner\Utils::startsWith(\trim($script), '/' . '* <![CDATA[ */');
        // Find all public content blockers and check URL
        if ($isJavascript && !$isCdata) {
            foreach ($blockers as $blocker) {
                $cookies = $blocker->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES];
                // Iterate all wildcarded URLs
                foreach ($blocker->regexp['contains'] as $regex) {
                    // m: Enable multiline search
                    if (\preg_match($regex . 'm', $script)) {
                        // This link is definitely blocked by configuration
                        $isBlocked = ['blocker' => $blocker, 'cookies' => $cookies];
                        break 2;
                    }
                }
            }
        }
        // Allow to skip content blocker by HTML attribute
        if (
            $isBlocked !== \false &&
            \DevOwl\RealCookieBanner\view\SkipBlockerTag::getInstance()->isSkipped($attributes)
        ) {
            $isBlocked = \false;
        }
        /**
         * Check if a given inline script is blocked.
         *
         * @hook RCB/Blocker/InlineScript/IsBlocked
         * @param {false|array} $isBlocked
         * @param {WP_Post[]} $blockers
         * @param {array} $attributes
         * @param {string} $script
         * @return {false|array} Return false, or an array ['blocker] => WP_Post blocker instance, ['cookies'] => of cookie ids which need to be consent to so the inline script is unblocked
         */
        return apply_filters('RCB/Blocker/InlineScript/IsBlocked', $isBlocked, $blockers, $attributes, $script);
    }
    /**
     * Callback for `preg_replace_callback` with the inline script regexp.
     *
     * @param mixed $m
     */
    public function replaceMatcherCallback($m) {
        list($attributes, $script) = $this->prepareMatch($m);
        $blocker = \DevOwl\RealCookieBanner\Core::getInstance()->getBlocker();
        $blockers = $blocker->getResolvedBlockers();
        $isBlocked = $this->isBlocked($blockers, $attributes, $script);
        if (!\is_array($isBlocked) || \DevOwl\RealCookieBanner\view\Blocker::isAlreadyBlocked($attributes)) {
            return $m[0];
        }
        // Prepare new attributes
        $attributes[\DevOwl\RealCookieBanner\view\Blocker::HTML_ATTRIBUTE_COOKIE_IDS] = \join(
            ',',
            $isBlocked['cookies']
        );
        $attributes[self::HTML_ATTRIBUTE_INLINE] = $script;
        $attributes[\DevOwl\RealCookieBanner\view\Blocker::HTML_ATTRIBUTE_BLOCKER_ID] = $isBlocked['blocker']->ID;
        /**
         * An inline script got blocked, e. g. `iframe`. We can now modify the attributes again to add an additional attribute to
         * the blocked script. Do not forget to hook into the frontend and transform the modified attributes!
         *
         * @hook RCB/Blocker/InlineScript/HTMLAttributes
         * @param {array} $attributes
         * @param {array} $isBlocked [blocker] => WP_Post blocker instance, [cookies] => List of needed cookie ids
         * @param {WP_Post[]} $blockers
         * @param {string} $script
         * @return {array}
         */
        $attributes = apply_filters(
            'RCB/Blocker/InlineScript/HTMLAttributes',
            $attributes,
            $isBlocked,
            $blockers,
            $script
        );
        return \sprintf(
            '<%1$s %2$s></%1$s>',
            self::HTML_TAG_CONSENT_SCRIPT,
            \DevOwl\RealCookieBanner\Utils::htmlAttributes($attributes)
        );
    }
    /**
     * Prepare the result match of a script inline regexp.
     *
     * @param array $m
     */
    public function prepareMatch($m) {
        $attributes = \DevOwl\RealCookieBanner\Utils::parseHtmlAttributes($m[1]);
        $script = $m[2];
        return [$attributes, $script];
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\view\ScriptInlineBlocker()) : self::$me;
    }
}
