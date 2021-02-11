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
 * Allows to block a definition like `div[class="fb-share-button"]`.
 */
class CustomElementBlocker {
    use UtilsProvider;
    const COMPARATOR_EQUAL = '=';
    const COMPARATOR_CONTAINS = '*=';
    const ALLOWED_COMPARATORS = [self::COMPARATOR_EQUAL, self::COMPARATOR_CONTAINS];
    public $tag;
    public $attribute;
    public $comparator;
    public $value;
    /**
     * The blocker.
     *
     * @var WP_Post
     */
    public $blocker;
    /**
     * See class description.
     *
     * Available matches:
     *      $match[0] => Full string
     *      $match[1] => Tag
     *      $match[2] => Attribute
     *      $match[3] => Comparator
     *      $match[4] => Value
     *
     * @see https://regex101.com/r/vlbn3Y/1/
     */
    const CUSTOM_ELEMENT_REGEXP = '/^([A-Za-z_-]+)\\[([A-Za-z_-]+)(%s)"([^"]+)"]$/';
    /**
     * C'tor.
     *
     * @param string $tag
     * @param string $attribute
     * @param string $comparator
     * @param string $value
     * @param WP_Post $blocker
     * @codeCoverageIgnore
     */
    private function __construct($tag, $attribute, $comparator, $value, $blocker) {
        $this->tag = $tag;
        $this->attribute = $attribute;
        $this->comparator = $comparator;
        $this->value = $value;
        $this->blocker = $blocker;
    }
    /**
     * Apply custom element blockers to a given HTML string.
     *
     * @param string $html
     */
    public function replace($html) {
        // Special case: <script>
        if ($this->tag === 'script') {
            return \preg_replace_callback(
                \str_replace(
                    'src=',
                    'NEVER_GETTING_A_HIT_KEEP_ATTRIBUTES',
                    \DevOwl\RealCookieBanner\view\ScriptInlineBlocker::SCRIPT_INLINE_REGEXP
                ),
                [$this, 'replaceInlineScriptCallback'],
                $html
            );
        }
        return \preg_replace_callback(
            \DevOwl\RealCookieBanner\view\Blocker::createRegexp([$this->tag], [$this->attribute]),
            [$this, 'replaceMatcherCallback'],
            $html
        );
    }
    /**
     * Callback for `preg_replace_callback` with a given inline scripts.
     *
     * @param mixed $m
     */
    public function replaceInlineScriptCallback($m) {
        list($attributes) = \DevOwl\RealCookieBanner\view\ScriptInlineBlocker::getInstance()->prepareMatch($m);
        // Check if our attribute exists and is set correctly
        if (!isset($attributes[$this->attribute]) || !$this->isCompareValid($attributes[$this->attribute])) {
            return $m[0];
        }
        // Differ between inline scripts and non-inline-scripts
        if (isset($attributes[\DevOwl\RealCookieBanner\view\SrcSetBlocker::HTML_ATTRIBUTE_SRC])) {
            // Force to block next match
            add_filter('RCB/Blocker/IsBlocked', [$this, 'getIsBlockedResult']);
            $result = \preg_replace_callback(
                \DevOwl\RealCookieBanner\view\Blocker::createRegexp(
                    [$this->tag],
                    [\DevOwl\RealCookieBanner\view\SrcSetBlocker::HTML_ATTRIBUTE_SRC]
                ),
                [\DevOwl\RealCookieBanner\Core::getInstance()->getBlocker(), 'replaceMatcherCallback'],
                $m[0]
            );
            remove_filter('RCB/Blocker/IsBlocked', [$this, 'getIsBlockedResult']);
        } else {
            // Force to block next match
            add_filter('RCB/Blocker/InlineScript/IsBlocked', [$this, 'getIsBlockedResult']);
            $result = \DevOwl\RealCookieBanner\view\ScriptInlineBlocker::getInstance()->replaceMatcherCallback($m);
            remove_filter('RCB/Blocker/InlineScript/IsBlocked', [$this, 'getIsBlockedResult']);
        }
        return $result;
    }
    /**
     * Callback for `preg_replace_callback` with a given `createRegexp` regexp.
     *
     * @param mixed $m
     */
    public function replaceMatcherCallback($m) {
        list(
            $beforeLinkAttribute,
            ,
            ,
            $foundValue,
            $afterLink,
            $attributes
        ) = \DevOwl\RealCookieBanner\view\Blocker::prepareMatch($m);
        // Compare and return original content if not matching
        if (
            !$this->isCompareValid($foundValue) ||
            \DevOwl\RealCookieBanner\view\Blocker::isAlreadyBlocked($attributes)
        ) {
            return $m[0];
        }
        // Re-add our attribute because it got lost with the regular expression
        $newAttribute = \DevOwl\RealCookieBanner\view\Blocker::HTML_ATTRIBUTE_CAPTURE_PREFIX . '-' . $this->attribute;
        $attributes[$newAttribute] = $foundValue;
        $attributes[\DevOwl\RealCookieBanner\view\Blocker::HTML_ATTRIBUTE_COOKIE_IDS] = \join(
            ',',
            $this->blocker->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES]
        );
        $attributes[\DevOwl\RealCookieBanner\view\Blocker::HTML_ATTRIBUTE_BLOCKER_ID] = $this->blocker->ID;
        // Disable known loading attributes like `href` or `src`
        foreach (\DevOwl\RealCookieBanner\view\Blocker::REPLACE_ATTRIBUTES as $loadingAttr) {
            if (isset($attributes[$loadingAttr])) {
                $newAttribute =
                    \DevOwl\RealCookieBanner\view\Blocker::HTML_ATTRIBUTE_CAPTURE_PREFIX . '-' . $loadingAttr;
                $attributes[$newAttribute] = $attributes[$loadingAttr];
                unset($attributes[$loadingAttr]);
            }
        }
        return \sprintf(
            '%1$s %2$s %3$s',
            $beforeLinkAttribute,
            \DevOwl\RealCookieBanner\Utils::htmlAttributes($attributes),
            $afterLink
        );
    }
    /**
     * Check a given value with the comparator.
     *
     * @param string $value
     */
    protected function isCompareValid($value) {
        switch ($this->comparator) {
            case self::COMPARATOR_EQUAL:
                if ($value !== $this->value) {
                    return \false;
                }
                break;
            case self::COMPARATOR_CONTAINS:
                if (\strpos($value, $this->value) === \false) {
                    return \false;
                }
                break;
            default:
                return \false;
        }
        return \true;
    }
    /**
     * Get the result for `RCB/Blocker/InlineScript/IsBlocked` filter for the current blocker.
     */
    public function getIsBlockedResult() {
        return [
            'blocker' => $this->blocker,
            'cookies' => $this->blocker->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES]
        ];
    }
    /**
     * Create an instance if the given string is a valid expression or return `false`.
     *
     * @param string $expression
     * @param WP_Post $blocker
     * @return false|CustomElementBlocker
     */
    public static function probableCreateInstance($expression, $blocker) {
        $regexp = \sprintf(
            self::CUSTOM_ELEMENT_REGEXP,
            \str_replace('*', '\\*', \join('|', self::ALLOWED_COMPARATORS))
        );
        \preg_match($regexp, $expression, $matches);
        if (!empty($matches)) {
            return new \DevOwl\RealCookieBanner\view\CustomElementBlocker(
                $matches[1],
                $matches[2],
                $matches[3],
                $matches[4],
                $blocker
            );
        }
        return \false;
    }
}
