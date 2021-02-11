<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
/**
 * SG Optimize.
 *
 * @see https://wordpress.org/plugins/sg-cachepress/
 * @codeCoverageIgnore
 */
class SGOptimizeImpl extends \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache {
    const IDENTIFIER = 'sg-cachepress';
    // Documented in AbstractCache
    public function isActive() {
        return \function_exists('sg_cachepress_purge_cache');
    }
    // Documented in AbstractCache
    public function invalidate() {
        return sg_cachepress_purge_cache();
    }
    // Documented in AbstractCache
    public function label() {
        return 'SG Optimize';
    }
}
