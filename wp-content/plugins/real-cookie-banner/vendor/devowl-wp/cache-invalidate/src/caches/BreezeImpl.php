<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
use Breeze_Admin;
/**
 * Breeze.
 *
 * @see https://wordpress.org/plugins/breeze/
 * @codeCoverageIgnore
 */
class BreezeImpl extends \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache {
    const IDENTIFIER = 'breeze';
    // Documented in AbstractCache
    public function isActive() {
        return \class_exists(\Breeze_Admin::class);
    }
    // Documented in AbstractCache
    public function invalidate() {
        $admin = $this->getAdminInstance();
        if ($admin !== null) {
            return $admin->breeze_clear_all_cache();
        } else {
            return \false;
        }
    }
    /**
     * Get the admin instance so we can safely clear the cache.
     *
     * @return Breeze_Admin|null
     */
    public function getAdminInstance() {
        global $wp_filter;
        if (isset($wp_filter['breeze_clear_all_cache'])) {
            $callbacks = $wp_filter['breeze_clear_all_cache']->callbacks;
            if (isset($callbacks['10'])) {
                foreach ($callbacks['10'] as $callback) {
                    if (\is_array($callback['function'])) {
                        $callee = $callback['function'][0];
                        if (\gettype($callee) === 'object' && \get_class($callee) === \Breeze_Admin::class) {
                            return $callee;
                        }
                    }
                }
            }
        }
        return null;
    }
    // Documented in AbstractCache
    public function label() {
        return 'Breeze';
    }
}
