<?php

namespace DevOwl\RealCookieBanner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\DeliverAnonymousAsset\AnonymousAssetBuilder;
use DevOwl\RealCookieBanner\Vendor\DevOwl\DeliverAnonymousAsset\DeliverAnonymousAsset;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\presets\BlockerPresets;
use DevOwl\RealCookieBanner\presets\CookiePresets;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
use DevOwl\RealCookieBanner\presets\Presets;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\settings\Revision;
use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Activator as UtilsActivator;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * The activator class handles the plugin relevant activation hooks: Uninstall, activation,
 * deactivation and installation. The "installation" means installing needed database tables.
 */
class Activator {
    use UtilsProvider;
    use UtilsActivator;
    const OPTION_NAME_INSTALLATION_DATE = RCB_OPT_PREFIX . '-installation-date';
    const OPTION_NAME_NEEDS_DEFAULT_CONTENT = RCB_OPT_PREFIX . '-needs-default-content';
    /**
     * Any plugin got deactivated / activated so let's recalculate the presets cache.
     */
    public function anyPluginToggledState() {
        (new \DevOwl\RealCookieBanner\presets\CookiePresets())->forceRegeneration();
        (new \DevOwl\RealCookieBanner\presets\BlockerPresets())->forceRegeneration();
    }
    /**
     * Method gets fired when the user activates the plugin.
     */
    public function activate() {
        // Your implementation...
    }
    /**
     * Method gets fired when the user deactivates the plugin.
     */
    public function deactivate() {
        // Your implementation...
    }
    /**
     * Add initial content after first installation.
     */
    public function addInitialContent() {
        // Only create in admin backend (e. g. PolyLang currentLanguage is not available in REST API requests)
        if (!is_admin() && current_user_can(\DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY)) {
            return;
        }
        // Initial content should be available in the current language
        $tempTd = \DevOwl\RealCookieBanner\comp\language\Hooks::getInstance()->createTemporaryTextDomain();
        // Create default groups
        \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->ensureEssentialGroupCreated();
        // Create default cookies (RCB)
        (new \DevOwl\RealCookieBanner\presets\CookiePresets())->createFromPreset(
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::REAL_COOKIE_BANNER,
            \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getEssentialGroup(\true)->term_id
        );
        delete_site_option(self::OPTION_NAME_NEEDS_DEFAULT_CONTENT);
        $tempTd->teardown();
    }
    /**
     * Detect first installation and conditionally create initial content.
     */
    public function detectFirstInstallation() {
        // Is it the first installation?
        if (empty(get_option(self::OPTION_NAME_INSTALLATION_DATE))) {
            // Default content needs to be inserted in `init` action, and can not ensured at this time (e. g. WP CLI activation)
            add_site_option(self::OPTION_NAME_NEEDS_DEFAULT_CONTENT, \true);
            // Add option initially of first installation date
            add_option(self::OPTION_NAME_INSTALLATION_DATE, \gmdate('Y-m-d'));
        }
    }
    /**
     * Install tables, stored procedures or whatever in the database.
     * This method is always called when the version bumps up or for
     * the first initial activation.
     *
     * @param boolean $errorlevel If true throw errors
     */
    public function dbDelta($errorlevel) {
        global $wpdb;
        // Retrigger presets regeneration
        (new \DevOwl\RealCookieBanner\presets\CookiePresets())->forceRegeneration();
        (new \DevOwl\RealCookieBanner\presets\BlockerPresets())->forceRegeneration();
        $this->detectFirstInstallation();
        $max_index_length = $this->getMaxIndexLength();
        // wp_rcb_revision
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\settings\Revision::TABLE_NAME);
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE {$table_name} (\n            id mediumint(9) UNSIGNED NOT NULL AUTO_INCREMENT,\n            json_revision text NOT NULL,\n            `hash` char(32) NOT NULL,\n            created datetime NOT NULL,\n            PRIMARY KEY  (id),\n            UNIQUE KEY `hash` (`hash`)\n        ) {$charset_collate};";
        dbDelta($sql);
        if ($errorlevel) {
            $wpdb->print_error();
        }
        // wp_rcb_stats
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\Stats::TABLE_NAME);
        $sql = "CREATE TABLE {$table_name} (\n            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n            context varchar(200) NOT NULL,\n            `day` date NOT NULL,\n            term_name varchar(70) NOT NULL,\n            term_id bigint(20) UNSIGNED NOT NULL,\n            accepted tinyint(1) NOT NULL,\n            `count` int UNSIGNED,\n            PRIMARY KEY  (id),\n            UNIQUE KEY `dayGroup` (`context`({$max_index_length}), `day`, `term_id`, `accepted`)\n        ) {$charset_collate};";
        dbDelta($sql);
        if ($errorlevel) {
            $wpdb->print_error();
        }
        // wp_rcb_revision_independent
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\settings\Revision::TABLE_NAME_INDEPENDENT);
        $sql = "CREATE TABLE {$table_name} (\n            id mediumint(9) UNSIGNED NOT NULL AUTO_INCREMENT,\n            json_revision text NOT NULL,\n            `hash` char(32) NOT NULL,\n            created datetime NOT NULL,\n            PRIMARY KEY  (id),\n            UNIQUE KEY `hash` (`hash`)\n        ) {$charset_collate};";
        dbDelta($sql);
        if ($errorlevel) {
            $wpdb->print_error();
        }
        // wp_rcb_consent
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\UserConsent::TABLE_NAME);
        $sql = "CREATE TABLE {$table_name} (\n            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n            ipv4 int UNSIGNED,\n            ipv6 binary(16),\n            ipv4_hash char(64),\n            ipv6_hash char(64),\n            uuid char(36) NOT NULL,\n            revision char(32) NOT NULL,\n            revision_independent char(32) NOT NULL,\n            previous_decision tinytext NOT NULL,\n            decision_hash char(32) NOT NULL,\n            decision tinytext NOT NULL,\n            blocker bigint(20) UNSIGNED,\n            button_clicked varchar(32) NOT NULL,\n            context varchar(200) NOT NULL,\n            viewport_width int UNSIGNED NOT NULL,\n            viewport_height int UNSIGNED NOT NULL,\n            referer tinytext NOT NULL,\n            url_imprint tinytext NOT NULL,\n            url_privacy_policy tinytext NOT NULL,\n            dnt tinyint(1) UNSIGNED NOT NULL,\n            created datetime NOT NULL,\n            forwarded bigint(20) UNSIGNED,\n            forwarded_blocker tinyint(1) NOT NULL,\n            PRIMARY KEY  (id)\n        ) {$charset_collate};";
        dbDelta($sql);
        if ($errorlevel) {
            $wpdb->print_error();
        }
        // wp_rcb_asset_seo_redirect (use own table name for backwards compatibility)
        \DevOwl\RealCookieBanner\Core::getInstance()
            ->getAnonymousAssetBuilder()
            ->dbDelta();
        if ($errorlevel) {
            $wpdb->print_error();
        }
        // wp_rcb_presets
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\presets\Presets::TABLE_NAME);
        $max_index_length_presets_identifier = $max_index_length - 70;
        // subtract length of other varchar fields
        $sql = "CREATE TABLE {$table_name} (\n            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n            identifier varchar(200) NOT NULL,\n            context varchar(50) NOT NULL,\n            type varchar(20) NOT NULL,\n            version int(11) NOT NULL,\n            description tinytext,\n            logoFile tinytext,\n            name varchar (255),\n            tags text,\n            attributes_name varchar(200),\n            disabled tinyint(1) NOT NULL,\n            hidden tinyint(1) NOT NULL,\n            other_meta text,\n            PRIMARY KEY  (id),\n            UNIQUE KEY `identifier` (`identifier`({$max_index_length_presets_identifier}), `context`, `type`)\n        ) {$charset_collate};";
        dbDelta($sql);
        if ($errorlevel) {
            $wpdb->print_error();
        }
    }
    /**
     * Uninstall our plugin (it does currently not remove any settings!).
     */
    public static function uninstall() {
        global $wpdb;
        // Delete anonymous JavaScript files
        $table_name =
            $wpdb->prefix .
            RCB_DB_PREFIX .
            '_' .
            \DevOwl\RealCookieBanner\Vendor\DevOwl\DeliverAnonymousAsset\AnonymousAssetBuilder::TABLE_NAME;
        foreach (['banner', 'blocker'] as $handle) {
            \DevOwl\RealCookieBanner\Vendor\DevOwl\DeliverAnonymousAsset\DeliverAnonymousAsset::uninstall(
                $table_name,
                \sprintf('%s-%s', RCB_SLUG, $handle),
                ['js']
            );
        }
    }
}
