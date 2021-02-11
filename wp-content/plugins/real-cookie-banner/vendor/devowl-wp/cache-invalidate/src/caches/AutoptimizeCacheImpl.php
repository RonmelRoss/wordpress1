<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
use autoptimizeCache;
/**
 * Autoptimize.
 *
 * @see https://wordpress.org/plugins/autoptimize/
 * @see https://www.davidkehr.com/wordpress-autoptimize-cache-automatisch-loeschen/
 * @codeCoverageIgnore
 */
class AutoptimizeCacheImpl extends \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache {
    const IDENTIFIER = 'autoptimize';
    // Documented in AbstractCache
    public function isActive() {
        return \class_exists(\autoptimizeCache::class);
    }
    // Documented in AbstractCache
    public function invalidate() {
        return \autoptimizeCache::clearall();
    }
    // Documented in AbstractCache
    public function label() {
        return 'Autoptimize';
    }
}
