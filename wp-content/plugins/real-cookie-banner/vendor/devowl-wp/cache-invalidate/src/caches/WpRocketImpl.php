<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
/**
 * WP Rocket.
 *
 * @see https://wp-rocket.me/
 * @see https://docs.wp-rocket.me/article/92-rocketcleandomain
 * @codeCoverageIgnore
 */
class WpRocketImpl extends \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache {
    const IDENTIFIER = 'wp-rocket';
    // Documented in AbstractCache
    public function isActive() {
        return \function_exists('rocket_clean_domain');
    }
    // Documented in AbstractCache
    public function invalidate() {
        return rocket_clean_domain();
    }
    // Documented in AbstractCache
    public function label() {
        return 'WP Rocket';
    }
}
