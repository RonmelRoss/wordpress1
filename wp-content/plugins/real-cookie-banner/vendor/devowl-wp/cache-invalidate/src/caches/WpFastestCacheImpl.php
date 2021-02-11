<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
/**
 * WP Fastest Cache.
 *
 * @see https://wordpress.org/plugins/wp-fastest-cache/
 * @see https://www.wpfastestcache.com/tutorial/delete-the-cache-by-calling-the-function/
 * @codeCoverageIgnore
 */
class WpFastestCacheImpl extends \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache {
    const IDENTIFIER = 'wp-fastest-cache';
    // Documented in AbstractCache
    public function isActive() {
        return \function_exists('wpfc_clear_all_cache');
    }
    // Documented in AbstractCache
    public function invalidate() {
        return wpfc_clear_all_cache();
    }
    // Documented in AbstractCache
    public function label() {
        return 'WP Fastest Cache';
    }
}
