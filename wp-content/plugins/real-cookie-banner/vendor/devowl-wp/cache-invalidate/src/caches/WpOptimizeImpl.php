<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
use WP_Optimize;
use WP_Optimize_Cache_Commands;
/**
 * WP Optimize.
 *
 * @see https://wordpress.org/plugins/wp-optimize/
 * @see https://getwpo.com/faqs/#Full-cache-purge-
 * @codeCoverageIgnore
 */
class WpOptimizeImpl extends \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache {
    const IDENTIFIER = 'wp-optimize';
    // Documented in AbstractCache
    public function isActive() {
        return \class_exists(\WP_Optimize::class) && \defined('WPO_PLUGIN_MAIN_PATH');
    }
    // Documented in AbstractCache
    public function invalidate() {
        // @codeCoverageIgnoreStart
        if (!\class_exists(\WP_Optimize_Cache_Commands::class) && !\defined('PHPUNIT_FILE')) {
            include_once \constant('WPO_PLUGIN_MAIN_PATH') . 'cache/class-cache-commands.php';
        }
        // @codeCoverageIgnoreEnd
        if (\class_exists('WP_Optimize_Cache_Commands')) {
            return (new \WP_Optimize_Cache_Commands())->purge_page_cache()['success'];
        } else {
            return \false;
        }
    }
    // Documented in AbstractCache
    public function label() {
        return 'WP Optimize';
    }
}
