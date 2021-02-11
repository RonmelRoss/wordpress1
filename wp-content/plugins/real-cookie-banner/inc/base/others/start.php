<?php

namespace DevOwl\RealCookieBanner\Vendor;

// We have now ensured that we are running the minimum PHP version.
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Freemium\Autoloader;
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// Check minimum WordPress version
global $wp_version;
if (\version_compare($wp_version, \RCB_MIN_WP, '>=')) {
    $load_core = \false;
    // Check minimum WordPress REST API
    if (\version_compare($wp_version, '4.7.0', '>=')) {
        $load_core = \true;
    } else {
        // Check WP REST API plugin is active
        require_once \ABSPATH . 'wp-admin/includes/plugin.php';
        $load_core = \is_plugin_active('rest-api/plugin.php');
    }
    // Load core
    if ($load_core) {
        // Composer autoload
        $composer_path = \path_join(\RCB_PATH, 'vendor/autoload.php');
        if (\file_exists($composer_path)) {
            require_once $composer_path;
        }
        // Dependents scoper autoload (PHP Scoper)
        $depAutoloaders = \glob(\path_join(\RCB_PATH, 'vendor/*/*/vendor/scoper-autoload.php'));
        foreach ($depAutoloaders as $composer_path) {
            require_once $composer_path;
        }
        // Dependents autoload
        $depAutoloaders = \glob(\path_join(\RCB_PATH, 'vendor/' . \RCB_ROOT_SLUG . '/*/vendor/autoload.php'));
        foreach ($depAutoloaders as $composer_path) {
            require_once $composer_path;
        }
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Freemium\Autoloader('RCB');
        // Do not start our plugin when we are uninstalling our plugin (just for registering autoloader)
        if (!\defined('WP_UNINSTALL_PLUGIN') || !\constant('WP_UNINSTALL_PLUGIN')) {
            \DevOwl\RealCookieBanner\Core::getInstance();
        }
    } else {
        // WP REST API version not reached
        require_once \RCB_INC . 'base/others/fallback-rest-api.php';
    }
} else {
    // Min WP version not reached
    require_once \RCB_INC . 'base/others/fallback-wp-version.php';
}
