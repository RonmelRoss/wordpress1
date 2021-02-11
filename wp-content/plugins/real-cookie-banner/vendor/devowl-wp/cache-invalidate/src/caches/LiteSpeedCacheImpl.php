<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
use LiteSpeed\Purge;
/**
 * LiteSpeed Cache
 *
 * @see https://wordpress.org/plugins/litespeed-cache/
 * @see https://www.litespeedtech.com/support/wiki/doku.php/litespeed_wiki:cache:lscwp:api#hooks
 * @codeCoverageIgnore
 */
class LiteSpeedCacheImpl extends \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache {
    const IDENTIFIER = 'litespeed-cache';
    // Documented in AbstractCache
    public function isActive() {
        return \class_exists(\LiteSpeed\Purge::class);
    }
    // Documented in AbstractCache
    public function invalidate() {
        return \LiteSpeed\Purge::purge_all('@devowl-wp/cache-invalidate');
    }
    // Documented in AbstractCache
    public function label() {
        return 'LiteSpeed Cache';
    }
}
