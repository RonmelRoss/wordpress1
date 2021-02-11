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
 * Block inline `<style>`'s.
 */
class StyleInlineBlocker {
    use UtilsProvider;
    /**
     * Inline styles are completely different than usual URL `link`s. We need to get
     * all available inline styles, scrape their content and check if it needs to blocked.
     *
     * Available matches:
     *      $match[0] => Full string
     *      $match[1] => Attributes string after `<style`
     *      $match[2] => Full inline style
     */
    const STYLE_INLINE_REGEXP = '/<style((?:(?!src=).)*?)>(.*?)<\\/style>/smix';
    // Also ported to `applyContentBlocker/listenOptIn.tsx`
    const HTML_ATTRIBUTE_INLINE_STYLE = 'consent-inline-style';
    /**
     * Singleton instance.
     *
     * @var StyleInlineBlocker
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
     * Check if a given inline style is blocked.
     *
     * @param WP_Post[] $blockers
     * @param array $attributes
     * @param string $style
     */
    public function isBlocked($blockers, $attributes, $style) {
        $isBlocked = \false;
        $isCSS = isset($attributes['type']) ? \strpos($attributes['type'], 'css') !== \false : \true;
        // Find all public content blockers and check URL
        if ($isCSS) {
            foreach ($blockers as $blocker) {
                $cookies = $blocker->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES];
                // Iterate all wildcarded URLs
                foreach ($blocker->regexp['contains'] as $regex) {
                    // m: Enable multiline search
                    if (\preg_match($regex . 'm', $style)) {
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
         * Check if a given inline style is blocked.
         *
         * @hook RCB/Blocker/InlineStyle/IsBlocked
         * @param {false|array} $isBlocked
         * @param {WP_Post[]} $blockers
         * @param {array} $attributes
         * @param {string} $style
         * @return {false|array} Return false, or an array ['blocker] => WP_Post blocker instance, ['cookies'] => of cookie ids which need to be consent to so the inline style is unblocked
         */
        return apply_filters('RCB/Blocker/InlineStyle/IsBlocked', $isBlocked, $blockers, $attributes, $style);
    }
    /**
     * Callback for `preg_replace_callback` with the inline style regexp.
     *
     * @param mixed $m
     */
    public function replaceMatcherCallback($m) {
        list($attributes, $style) = $this->prepareMatch($m);
        $blocker = \DevOwl\RealCookieBanner\Core::getInstance()->getBlocker();
        $blockers = $blocker->getResolvedBlockers();
        $isBlocked = $this->isBlocked($blockers, $attributes, $style);
        if (!\is_array($isBlocked) || \DevOwl\RealCookieBanner\view\Blocker::isAlreadyBlocked($attributes)) {
            return $m[0];
        }
        // Prepare new attributes
        $attributes[\DevOwl\RealCookieBanner\view\Blocker::HTML_ATTRIBUTE_COOKIE_IDS] = \join(
            ',',
            $isBlocked['cookies']
        );
        $attributes[self::HTML_ATTRIBUTE_INLINE_STYLE] = $style;
        $attributes[\DevOwl\RealCookieBanner\view\Blocker::HTML_ATTRIBUTE_BLOCKER_ID] = $isBlocked['blocker']->ID;
        /**
         * An inline style got blocked. We can now modify the attributes again to add an additional attribute to
         * the blocked style. Do not forget to hook into the frontend and transform the modified attributes!
         *
         * @hook RCB/Blocker/InlineStyle/HTMLAttributes
         * @param {array} $attributes
         * @param {array} $isBlocked [blocker] => WP_Post blocker instance, [cookies] => List of needed cookie ids
         * @param {WP_Post[]} $blockers
         * @param {string} $style
         * @return {array}
         */
        $attributes = apply_filters(
            'RCB/Blocker/InlineStyle/HTMLAttributes',
            $attributes,
            $isBlocked,
            $blockers,
            $style
        );
        return \sprintf(
            '<%1$s %2$s></%1$s>',
            \DevOwl\RealCookieBanner\view\ScriptInlineBlocker::HTML_TAG_CONSENT_SCRIPT,
            \DevOwl\RealCookieBanner\Utils::htmlAttributes($attributes)
        );
    }
    /**
     * Prepare the result match of a style inline regexp.
     *
     * @param array $m
     */
    public function prepareMatch($m) {
        $attributes = \DevOwl\RealCookieBanner\Utils::parseHtmlAttributes($m[1]);
        $style = $m[2];
        return [$attributes, $style];
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\view\StyleInlineBlocker()) : self::$me;
    }
}
