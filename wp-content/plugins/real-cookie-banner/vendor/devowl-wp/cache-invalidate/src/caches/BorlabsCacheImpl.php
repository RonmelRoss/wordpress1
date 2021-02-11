<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
use Borlabs\Cache\Frontend\Garbage;
/**
 * Borlabs Cache.
 *
 * @see https://de.borlabs.io/borlabs-cache/
 * @codeCoverageIgnore
 */
class BorlabsCacheImpl extends \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache {
    const IDENTIFIER = 'borlabs-cache';
    // Documented in AbstractCache
    public function isActive() {
        return \class_exists(\Borlabs\Cache\Frontend\Garbage::class);
    }
    // Documented in AbstractCache
    public function invalidate() {
        \Borlabs\Cache\Frontend\Garbage::getInstance()->clearStylesPreCacheFiles();
        return \Borlabs\Cache\Frontend\Garbage::getInstance()->clearCache();
    }
    // Documented in AbstractCache
    public function label() {
        return 'Borlabs Cache';
    }
}
