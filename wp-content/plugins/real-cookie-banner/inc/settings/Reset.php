<?php

namespace DevOwl\RealCookieBanner\settings;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\BlockerPresets;
use DevOwl\RealCookieBanner\presets\CookiePresets;
use DevOwl\RealCookieBanner\UserConsent;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Allows to reset all data of RCB including cookies, options, and cookie groups.
 */
class Reset {
    use UtilsProvider;
    /**
     * Singleton instance.
     *
     * @var Reset
     */
    private static $me = null;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Clear all data.
     */
    public function all() {
        global $wpdb;
        (new \DevOwl\RealCookieBanner\presets\CookiePresets())->forceRegeneration();
        (new \DevOwl\RealCookieBanner\presets\BlockerPresets())->forceRegeneration();
        // Custom post types
        $postIds = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts} WHERE post_type IN (%s, %s)",
                \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME,
                \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME
            )
        );
        if (!empty($postIds)) {
            foreach ($postIds as $postId) {
                wp_delete_post($postId, \true);
            }
        }
        // Custom taxonomies
        $terms = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT term_id, taxonomy FROM {$wpdb->term_taxonomy} WHERE taxonomy IN (%s)",
                \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME
            )
        );
        if (!empty($terms)) {
            foreach ($terms as $term) {
                wp_delete_term($term->term_id, $term->taxonomy);
            }
        }
        // Options
        $optionNames = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s AND option_name NOT IN('rcb-installation-date')",
                RCB_OPT_PREFIX . '-%'
            )
        );
        if (!empty($optionNames)) {
            foreach ($optionNames as $option_name) {
                delete_option($option_name);
            }
        }
        \DevOwl\RealCookieBanner\UserConsent::getInstance()->purge();
        \DevOwl\RealCookieBanner\Core::getInstance()
            ->getActivator()
            ->addInitialContent();
    }
    /**
     * Get singleton instance.
     *
     * @return Reset
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\settings\Reset()) : self::$me;
    }
}
