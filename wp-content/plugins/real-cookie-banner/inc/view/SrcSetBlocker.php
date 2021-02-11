<?php

namespace DevOwl\RealCookieBanner\view;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use WP_Post;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Block `srcset` attribute for media tags.
 *
 * @see https://www.w3schools.com/tags/tag_img.asp
 * @see https://www.w3schools.com/tags/tag_source.asp
 */
class SrcSetBlocker {
    use UtilsProvider;
    const HTML_TAG_SOURCE = 'source';
    const HTML_TAG_IMG = 'img';
    const HTML_ATTRIBUTE_SRCSET = 'srcset';
    const HTML_ATTRIBUTE_SRC = 'src';
    /**
     * Singleton instance.
     *
     * @var SrcSetBlocker
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
     * A `<video` and `<audio` tag uses a set of `<source` tags with `src` attribute.
     *
     * @param string $html
     */
    public function srcTagHtml($html) {
        $regexp = \DevOwl\RealCookieBanner\view\Blocker::createRegexp(
            [self::HTML_TAG_SOURCE],
            [self::HTML_ATTRIBUTE_SRC]
        );
        return \preg_replace_callback(
            $regexp,
            [\DevOwl\RealCookieBanner\Core::getInstance()->getBlocker(), 'replaceMatcherCallback'],
            $html
        );
    }
    /**
     * A `<picture` tag uses a set of `<source` tags with `srcset` attribute.
     *
     * @param string $html
     */
    public function srcsetTagHtml($html) {
        $regexp = \DevOwl\RealCookieBanner\view\Blocker::createRegexp(
            [self::HTML_TAG_SOURCE],
            [self::HTML_ATTRIBUTE_SRCSET]
        );
        return \preg_replace_callback(
            $regexp,
            [\DevOwl\RealCookieBanner\Core::getInstance()->getBlocker(), 'replaceMatcherCallback'],
            $html
        );
    }
    /**
     * Create an additional `use-parent` attribute to the DOM element so the content blocker get's created
     * for the main media tag like `<video`.
     *
     * @param array $attributes
     * @param array $isBlocked
     * @param WP_Post[] $blockers
     * @param string $tag
     */
    public function useVisualParentAttribute($attributes, $isBlocked, $blockers, $tag) {
        if ($tag === self::HTML_TAG_SOURCE && $isBlocked['blocker']->metas['visual']) {
            $attributes[\DevOwl\RealCookieBanner\view\Blocker::HTML_ATTRIBUTE_VISUAL_PARENT] = \true;
        }
        return $attributes;
    }
    /**
     * We can surely prefix a blocked `<img` tag.
     *
     * @param array $attributes
     * @param array $isBlocked
     * @param WP_Post[] $blockers
     * @param string $tag
     */
    public function imgAttributes($attributes, $isBlocked, $blockers, $tag) {
        if ($tag === self::HTML_TAG_IMG && isset($attributes[self::HTML_ATTRIBUTE_SRCSET])) {
            $newSrcAttribute =
                \DevOwl\RealCookieBanner\view\Blocker::HTML_ATTRIBUTE_CAPTURE_PREFIX .
                '-' .
                self::HTML_ATTRIBUTE_SRCSET;
            $attributes[$newSrcAttribute] = $attributes[self::HTML_ATTRIBUTE_SRCSET];
            unset($attributes[self::HTML_ATTRIBUTE_SRCSET]);
        }
        return $attributes;
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\view\SrcSetBlocker()) : self::$me;
    }
}
