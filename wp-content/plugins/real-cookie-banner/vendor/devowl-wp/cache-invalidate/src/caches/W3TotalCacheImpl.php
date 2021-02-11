<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
/**
 * W3 Total Cache.
 *
 * @see https://wordpress.org/plugins/w3-total-cache/
 * @see http://hookr.io/plugins/w3-total-cache/0.9.5.1/hooks/#index=g
 * @codeCoverageIgnore
 */
class W3TotalCacheImpl extends \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache {
    const IDENTIFIER = 'w3-total-cache';
    // Documented in AbstractCache
    public function isActive() {
        return \function_exists('w3tc_pgcache_flush');
    }
    // Documented in AbstractCache
    public function invalidate() {
        return w3tc_pgcache_flush();
    }
    // Documented in AbstractCache
    public function label() {
        return 'W3 Total Cache';
    }
}
