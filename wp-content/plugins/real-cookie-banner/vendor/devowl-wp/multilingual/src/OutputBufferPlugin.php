<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual;

// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Singleton instance handler for `AbstractOutputBufferPlugin`. Why a singleton? Output-
 * buffer-plugins are much more easier than WPML or PolyLang and we can only provide a small
 * set of APIs and they work very functional.
 */
class OutputBufferPlugin {
    /**
     * Singleton instance.
     *
     * @var AbstractOutputBufferPlugin
     */
    private static $me;
    /**
     * Check if PolyLang is active.
     */
    public static function getInstance() {
        return self::$me === null
            ? (self::$me = \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractOutputBufferPlugin::determineImplementation())
            : self::$me;
    }
}
