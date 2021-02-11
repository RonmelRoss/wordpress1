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
 * Block `href` attribute for special links. Usually, the blocker does not block
 * links cause they do not load external sources. But there are some special cases, e.g.
 * lightbox plugins which need a content blocker for a link.
 *
 * @see https://www.w3schools.com/tags/tag_a.asp
 */
class LinkBlocker {
    use UtilsProvider;
    const REPLACE_TAGS = ['a'];
    const REPLACE_ATTRIBUTES = ['href'];
    const REPLACE_ONLY_IF_CLASS = [
        // [Plugin Comp] https://wordpress.org/plugins/foobox-image-lightbox/
        'foobox'
    ];
    /**
     * Singleton instance.
     *
     * @var LinkBlocker
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
     * Replace the original HTML with modified links.
     *
     * @param string $html
     */
    public function replace($html) {
        $html = \preg_replace_callback(
            \DevOwl\RealCookieBanner\view\Blocker::createRegexp(self::REPLACE_TAGS, self::REPLACE_ATTRIBUTES),
            [\DevOwl\RealCookieBanner\Core::getInstance()->getBlocker(), 'replaceMatcherCallback'],
            $html
        );
        return $html;
    }
    /**
     * Check if the found link has a given class and only block it if the class is present.
     *
     * @param false|array $isBlocked
     * @param WP_Post[] $blockers
     * @param string $tag
     * @param string $linkAttribute
     * @param string $link
     * @param array $attributes
     */
    public function isBlocked($isBlocked, $blockers, $tag, $linkAttribute, $link, $attributes) {
        if ($isBlocked !== \false && \in_array($tag, self::REPLACE_TAGS, \true) && isset($attributes['class'])) {
            $classes = \explode(' ', $attributes['class']);
            /**
             * In some cases we need to block a link by the `href`. But Real Cookie Banner does
             * never block `a` tags cause the do not produce external server calls. So, the solution
             * is to block a link by `href` and an associated `class`. This can be useful for lightbox
             * plugins for example.
             *
             * @hook RCB/Blocker/BlockLinkByClass
             * @param {string[]} $classes
             * @param {false|array} $isBlocked
             * @param {WP_Post[]} $blockers
             * @param {string} $tag
             * @param {string} $linkAttribute
             * @param {string} $link
             * @param {array} $attributes
             * @return {string[]}
             * @since 1.6.1
             */
            $replaceOnlyIfClass = apply_filters(
                'RCB/Blocker/BlockLinkByClass',
                self::REPLACE_ONLY_IF_CLASS,
                $isBlocked,
                $blockers,
                $tag,
                $linkAttribute,
                $link,
                $attributes
            );
            foreach ($classes as $class) {
                $class = \strtolower($class);
                foreach ($replaceOnlyIfClass as $value) {
                    if ($class === $value) {
                        return $isBlocked;
                    }
                }
            }
            return \false;
        }
        return $isBlocked;
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\view\LinkBlocker()) : self::$me;
    }
}
