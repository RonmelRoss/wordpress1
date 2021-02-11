<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate;

/**
 * Implement a cache mechanism / plugin.
 */
abstract class AbstractCache {
    /**
     * Check if the caching mechanism / plugin is active and available.
     *
     * @return boolean
     */
    abstract public function isActive();
    /**
     * Trigger a cache invalidation.
     *
     * @return mixed
     */
    abstract public function invalidate();
    /**
     * Get the label.
     */
    abstract public function label();
}
