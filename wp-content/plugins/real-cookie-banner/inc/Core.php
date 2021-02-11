<?php

namespace DevOwl\RealCookieBanner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\Core as CustomizeCore;
use DevOwl\RealCookieBanner\Vendor\DevOwl\DeliverAnonymousAsset\AnonymousAssetBuilder;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractLanguagePlugin;
use DevOwl\RealCookieBanner\base\Core as BaseCore;
use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\lite\Core as LiteCore;
use DevOwl\RealCookieBanner\overrides\interfce\IOverrideCore;
use DevOwl\RealCookieBanner\presets\middleware\BlockerExistsMiddleware;
use DevOwl\RealCookieBanner\presets\middleware\CookieBlockerPresetIdsMiddleware;
use DevOwl\RealCookieBanner\presets\middleware\CookieExistsMiddleware;
use DevOwl\RealCookieBanner\presets\middleware\CookieManagerMiddleware;
use DevOwl\RealCookieBanner\presets\middleware\DisableTechnicalHandlingThroughPluginMiddleware;
use DevOwl\RealCookieBanner\presets\middleware\ExtendsMiddleware;
use DevOwl\RealCookieBanner\rest\Presets;
use DevOwl\RealCookieBanner\rest\Config;
use DevOwl\RealCookieBanner\rest\Import;
use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\view\Banner;
use DevOwl\RealCookieBanner\view\ConfigPage;
use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\settings\Consent;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\settings\Multisite;
use DevOwl\RealCookieBanner\presets\UpdateNotice;
use DevOwl\RealCookieBanner\rest\Consent as RestConsent;
use DevOwl\RealCookieBanner\rest\Stats as RestStats;
use DevOwl\RealCookieBanner\settings\ModalHints;
use DevOwl\RealCookieBanner\settings\Reset;
use DevOwl\RealCookieBanner\view\Blocker as ViewBlocker;
use DevOwl\RealCookieBanner\view\checklist\ActivateBanner;
use DevOwl\RealCookieBanner\view\checklist\AddCookie;
use DevOwl\RealCookieBanner\view\checklist\SaveSettings;
use DevOwl\RealCookieBanner\view\LinkBlocker;
use DevOwl\RealCookieBanner\view\shortcode\LinkShortcode;
use DevOwl\RealCookieBanner\view\shortcode\PrintUuidShortcode;
use DevOwl\RealCookieBanner\view\SrcSetBlocker;
use DevOwl\RealCookieBanner\Vendor\DevOwl\RealUtils\Core as RealUtilsCore;
use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Service;
use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\ServiceNoStore;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Singleton core class which handles the main system for plugin. It includes
 * registering of the autoload, all hooks (actions & filters) (see BaseCore class).
 */
class Core extends \DevOwl\RealCookieBanner\base\Core implements
    \DevOwl\RealCookieBanner\overrides\interfce\IOverrideCore {
    use LiteCore;
    use CustomizeCore;
    /**
     * The minimal required capability so a user can manage cookies.
     */
    const MANAGE_MIN_CAPABILITY = 'manage_options';
    /**
     * Singleton instance.
     *
     * @var Core
     */
    private static $me = null;
    /**
     * The config page.
     *
     * @var ConfigPage
     */
    private $configPage;
    /**
     * The banner.
     *
     * @var Banner
     */
    private $banner;
    /**
     * The blocker.
     *
     * @var ViewBlocker
     */
    private $blocker;
    /**
     * An unique id for this page request. This is e. g. needed for unique overlay id.
     *
     * @var string
     */
    private $pageRequestUuid4;
    /**
     * See AbstractLanguagePlugin.
     *
     * @var AbstractLanguagePlugin
     */
    private $compLanguage;
    /**
     * See AdInitiator.
     *
     * @var AdInitiator
     */
    private $adInitiator;
    /**
     * See RpmInitiator.
     *
     * @var RpmInitiator
     */
    private $rpmInitiator;
    /**
     * See AnonymousAssetBuilder.
     *
     * @var AnonymousAssetBuilder
     */
    private $anonymousAssetBuilder;
    /**
     * Application core constructor.
     */
    protected function __construct() {
        parent::__construct();
        // The Uuid4 must start with a non-number character to work with CSS selectors
        $this->pageRequestUuid4 = 'a' . wp_generate_uuid4();
        $this->blocker = \DevOwl\RealCookieBanner\view\Blocker::instance();
        // Create multilingual instance
        $path = untrailingslashit(plugin_dir_path(RCB_FILE)) . $this->getPluginData('DomainPath');
        $mo = trailingslashit($path) . RCB_TD . '-%s.mo';
        $this->compLanguage = \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractLanguagePlugin::determineImplementation(
            RCB_TD,
            $mo,
            \DevOwl\RealCookieBanner\Localization::class
        );
        // Enable `no-store` for our relevant WP REST API endpoints
        \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\ServiceNoStore::hook(
            '/' . \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Service::getNamespace($this)
        );
        \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\ServiceNoStore::hook('/wp/v2/rcb-');
        // Custom Post Types
        // Register preset middleware
        $extendsMiddleware = new \DevOwl\RealCookieBanner\presets\middleware\ExtendsMiddleware();
        add_filter('RCB/Presets/Cookies/Middleware', [$extendsMiddleware, 'middleware'], 1);
        add_filter(
            'RCB/Presets/Cookies/Middleware',
            [
                new \DevOwl\RealCookieBanner\presets\middleware\DisableTechnicalHandlingThroughPluginMiddleware(),
                'middleware'
            ],
            1
        );
        add_filter(
            'RCB/Presets/Cookies/Middleware',
            [new \DevOwl\RealCookieBanner\presets\middleware\CookieManagerMiddleware(), 'middleware'],
            10,
            2
        );
        add_filter(
            'RCB/Presets/Cookies/Middleware',
            [new \DevOwl\RealCookieBanner\presets\middleware\CookieExistsMiddleware(), 'middleware'],
            9,
            3
        );
        add_filter(
            'RCB/Presets/Cookies/Middleware',
            [new \DevOwl\RealCookieBanner\presets\middleware\CookieBlockerPresetIdsMiddleware(), 'middleware'],
            10,
            4
        );
        add_filter('RCB/Presets/Blocker/Middleware', [$extendsMiddleware, 'middleware'], 1);
        add_filter(
            'RCB/Presets/Blocker/Middleware',
            [new \DevOwl\RealCookieBanner\presets\middleware\BlockerExistsMiddleware(), 'middleware'],
            10,
            3
        );
        // Official Consent API
        add_filter('Consent/Block/HTML', [$this->getBlocker(), 'replace']);
        add_action('activated_plugin', [$this->getActivator(), 'anyPluginToggledState']);
        add_action('deactivated_plugin', [$this->getActivator(), 'anyPluginToggledState']);
        add_action('admin_init', [\DevOwl\RealCookieBanner\settings\Cookie::getInstance(), 'register_cap']);
        add_action('admin_init', [\DevOwl\RealCookieBanner\settings\Blocker::getInstance(), 'register_cap']);
        add_action('admin_init', [$this, 'registerSettings'], 1);
        add_action('rest_api_init', [$this, 'registerSettings'], 1);
        add_action('plugins_loaded', [\DevOwl\RealCookieBanner\Localization::class, 'multilingual'], 1);
        add_action('wp', [$this->getAssets(), 'createHashedAssets']);
        add_action(
            'plugins_loaded',
            [$this->getBlocker(), 'registerOutputBuffer'],
            \DevOwl\RealCookieBanner\view\Blocker::OB_START_PLUGINS_LOADED_PRIORITY
        );
        add_filter('customize_save_response', [$this, 'customize_save_response'], 10, 1);
        // Cache relevant hooks
        add_filter('RCB/Customize/Updated', [\DevOwl\RealCookieBanner\Cache::getInstance(), 'customize_updated']);
        add_filter('RCB/Settings/Updated', [\DevOwl\RealCookieBanner\Cache::getInstance(), 'settings_updated']);
        add_filter('RCB/Settings/Updated', [
            \DevOwl\RealCookieBanner\view\checklist\SaveSettings::class,
            'settings_updated'
        ]);
        add_filter(
            'RCB/Settings/Updated',
            [\DevOwl\RealCookieBanner\view\checklist\ActivateBanner::class, 'settings_updated'],
            10,
            2
        );
        add_filter('RCB/Revision/Hash', [\DevOwl\RealCookieBanner\Cache::getInstance(), 'revision_hash']);
        // Compatibility hooks (Blocker)
        add_filter('rocket_buffer', [$this->getBlocker(), 'replace'], 1);
        // WP Rocket Lazy loading compatibility
        add_filter('us_grid_listing_post', [$this->getBlocker(), 'replace']);
        // Impreza Lazy Loading posts
        add_shortcode(\DevOwl\RealCookieBanner\view\shortcode\LinkShortcode::TAG, [
            \DevOwl\RealCookieBanner\view\shortcode\LinkShortcode::class,
            'render'
        ]);
        add_shortcode(\DevOwl\RealCookieBanner\view\shortcode\PrintUuidShortcode::TAG, [
            \DevOwl\RealCookieBanner\view\shortcode\PrintUuidShortcode::class,
            'render'
        ]);
        $this->adInitiator = new \DevOwl\RealCookieBanner\AdInitiator();
        $this->adInitiator->start();
        $this->rpmInitiator = new \DevOwl\RealCookieBanner\RpmInitiator();
        $this->rpmInitiator->start();
        $this->anonymousAssetBuilder = new \DevOwl\RealCookieBanner\Vendor\DevOwl\DeliverAnonymousAsset\AnonymousAssetBuilder(
            $this->getTableName(
                \DevOwl\RealCookieBanner\Vendor\DevOwl\DeliverAnonymousAsset\AnonymousAssetBuilder::TABLE_NAME
            ),
            RCB_OPT_PREFIX,
            \true
        );
        $this->overrideConstructFreemium();
        $this->overrideConstruct();
    }
    /**
     * Define constants which relies on i18n localization loaded.
     */
    public function i18n() {
        parent::i18n();
        \define('RCB_PRO_VERSION', __('https://devowl.io/go/real-cookie-banner?source=rcb-lite', RCB_TD));
    }
    /**
     * Register settings.
     */
    public function registerSettings() {
        \DevOwl\RealCookieBanner\settings\General::getInstance()->register();
        \DevOwl\RealCookieBanner\settings\Consent::getInstance()->register();
        \DevOwl\RealCookieBanner\settings\Multisite::getInstance()->register();
        $this->overrideRegisterSettings();
    }
    /**
     * The init function is fired even the init hook of WordPress. If possible
     * it should register all hooks to have them in one place.
     */
    public function init() {
        \DevOwl\RealCookieBanner\settings\Cookie::getInstance()->register();
        \DevOwl\RealCookieBanner\settings\Blocker::getInstance()->register();
        \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->register();
        $this->configPage = \DevOwl\RealCookieBanner\view\ConfigPage::instance();
        $this->banner = \DevOwl\RealCookieBanner\view\Banner::instance();
        $presetsService = \DevOwl\RealCookieBanner\rest\Presets::instance();
        $configService = \DevOwl\RealCookieBanner\rest\Config::instance();
        // Register all your hooks here
        add_action('rest_api_init', [$presetsService, 'rest_api_init']);
        add_action('rest_api_init', [$configService, 'rest_api_init']);
        add_action('rest_api_init', [\DevOwl\RealCookieBanner\rest\Consent::instance(), 'rest_api_init']);
        add_action('rest_api_init', [\DevOwl\RealCookieBanner\rest\Stats::instance(), 'rest_api_init']);
        add_action('rest_api_init', [\DevOwl\RealCookieBanner\rest\Import::instance(), 'rest_api_init']);
        add_action('admin_enqueue_scripts', [$this->getAssets(), 'admin_enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this->getAssets(), 'wp_enqueue_scripts'], 0);
        add_action('admin_menu', [$this->getConfigPage(), 'admin_menu']);
        add_filter(
            'plugin_action_links_' . plugin_basename(RCB_FILE),
            [$this->getConfigPage(), 'plugin_action_links'],
            10,
            2
        );
        add_action('customize_register', [$this->getBanner()->getCustomize(), 'customize_register']);
        add_action('wp_footer', [$this->getBanner(), 'wp_footer']);
        add_action('admin_bar_menu', [$this->getBanner(), 'admin_bar_menu'], 100);
        add_action(
            'save_post_' . \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME,
            [\DevOwl\RealCookieBanner\view\checklist\AddCookie::class, 'save_post'],
            10,
            3
        );
        add_action(
            'save_post_' . \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME,
            [\DevOwl\RealCookieBanner\settings\Blocker::getInstance(), 'save_post'],
            10,
            3
        );
        add_action('save_post_' . \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME, [
            \DevOwl\RealCookieBanner\Cache::getInstance(),
            'invalidate'
        ]);
        add_action(
            'delete_' . \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME,
            [\DevOwl\RealCookieBanner\settings\CookieGroup::getInstance(), 'deleted'],
            10,
            4
        );
        add_action('edited_' . \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME, [
            \DevOwl\RealCookieBanner\Stats::getInstance(),
            'edited_group'
        ]);
        add_action('deleted_post', [\DevOwl\RealCookieBanner\settings\Blocker::getInstance(), 'deleted_post']);
        add_action('admin_notices', [new \DevOwl\RealCookieBanner\presets\UpdateNotice(), 'admin_notices']);
        add_action('admin_notices', [$this->getConfigPage(), 'admin_notices']);
        add_filter('rest_post_dispatch', [$configService, 'rest_post_dispatch'], 10, 3);
        add_filter(
            'rest_prepare_' . \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME,
            [$presetsService, 'rest_prepare_presets'],
            10,
            2
        );
        add_filter(
            'rest_prepare_' . \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME,
            [$presetsService, 'rest_prepare_presets'],
            10,
            2
        );
        add_filter(
            'RCB/Blocker/HTMLAttributes',
            [\DevOwl\RealCookieBanner\view\SrcSetBlocker::getInstance(), 'imgAttributes'],
            10,
            4
        );
        add_filter(
            'RCB/Blocker/HTMLAttributes',
            [\DevOwl\RealCookieBanner\view\SrcSetBlocker::getInstance(), 'useVisualParentAttribute'],
            10,
            4
        );
        add_filter('RCB/Blocker/HTML', [\DevOwl\RealCookieBanner\view\SrcSetBlocker::getInstance(), 'srcTagHtml']);
        add_filter('RCB/Blocker/HTML', [\DevOwl\RealCookieBanner\view\SrcSetBlocker::getInstance(), 'srcsetTagHtml']);
        add_filter('RCB/Blocker/HTML', [\DevOwl\RealCookieBanner\view\LinkBlocker::getInstance(), 'replace']);
        add_filter(
            'RCB/Blocker/IsBlocked',
            [\DevOwl\RealCookieBanner\view\LinkBlocker::getInstance(), 'isBlocked'],
            10,
            6
        );
        add_filter('RCB/Revision/Array', [\DevOwl\RealCookieBanner\settings\Blocker::getInstance(), 'revisionArray']);
        // Multilingual
        add_filter('rest_' . \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME . '_query', [
            \DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(),
            'rest_query'
        ]);
        add_filter('rest_' . \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME . '_query', [
            \DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(),
            'rest_query'
        ]);
        add_action('rest_api_init', [\DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(), 'rest_api_init'], 1);
        add_filter('RCB/Hints', [\DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(), 'hints']);
        add_filter('RCB/Query/Arguments', [
            \DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(),
            'queryArguments'
        ]);
        add_filter(
            'DevOwl/Multilingual/Copy/Meta/post/' . \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES,
            [\DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(), 'copy_blocker_cookies_meta'],
            10,
            4
        );
        add_filter('RCB/Revision/Option/' . \DevOwl\RealCookieBanner\settings\General::SETTING_IMPRINT_ID, [
            \DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(),
            'revisionOptionValue_pageId'
        ]);
        add_filter('RCB/Revision/Option/' . \DevOwl\RealCookieBanner\settings\General::SETTING_PRIVACY_POLICY_ID, [
            \DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(),
            'revisionOptionValue_pageId'
        ]);
        add_filter('RCB/Revision/Context', [\DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(), 'context']);
        add_filter('RCB/Revision/Context/Translate', [
            \DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(),
            'contextTranslate'
        ]);
        add_filter('RCB/Revision/Hash', [\DevOwl\RealCookieBanner\comp\language\Hooks::getInstance(), 'revisionHash']);
        add_filter(
            'RCB/Presets/Cookies',
            [\DevOwl\RealCookieBanner\DemoEnvironment::getInstance(), 'cookiePresets'],
            \PHP_INT_MAX
        );
        add_filter(
            'RCB/Presets/Blocker',
            [\DevOwl\RealCookieBanner\DemoEnvironment::getInstance(), 'blockerPresets'],
            \PHP_INT_MAX
        );
        // Allow to reset all available data and recreated
        if (isset($_GET['rcb-reset-all']) && current_user_can('install_plugins')) {
            \DevOwl\RealCookieBanner\settings\Reset::getInstance()->all();
            wp_safe_redirect($this->getConfigPage()->getUrl());
        }
        // Create default content
        if (
            $this->getConfigPage()->isVisible() &&
            (get_site_option(\DevOwl\RealCookieBanner\Activator::OPTION_NAME_NEEDS_DEFAULT_CONTENT) ||
                \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getEssentialGroup() === null)
        ) {
            $this->getActivator()->addInitialContent();
        }
        $this->getBanner()
            ->getCustomize()
            ->enableOptionsAutoload();
        \DevOwl\RealCookieBanner\settings\General::getInstance()->enableOptionsAutoload();
        \DevOwl\RealCookieBanner\settings\Consent::getInstance()->enableOptionsAutoload();
        \DevOwl\RealCookieBanner\settings\Multisite::getInstance()->enableOptionsAutoload();
        \DevOwl\RealCookieBanner\settings\ModalHints::getInstance()->enableOptionsAutoload();
        $this->overrideInitCustomize();
        $this->overrideInit();
    }
    /**
     * Check if any plugin specific setting got changed in customize.
     *
     * @param array $response
     */
    public function customize_save_response($response) {
        if (
            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::gotUpdated(
                $response,
                RCB_OPT_PREFIX
            )
        ) {
            /**
             * Real Cookie Banner (Content Blocker, banner) got updated in the Customize.
             *
             * @hook RCB/Customize/Updated
             * @param {array} $response
             * @return {array}
             */
            $response = apply_filters('RCB/Customize/Updated', $response);
        }
        return $response;
    }
    /**
     * See filter RCB/Query/Arguments.
     *
     * @param array $arguments
     * @param string $context
     */
    public function queryArguments($arguments, $context) {
        /**
         * Modify arguments to `get_posts` and `get_terms`. This can be especially useful for WPML / PolyLang.
         *
         * @hook RCB/Query/Arguments
         * @param {array} $arguments
         * @param {string} $context
         * @return {array}
         */
        return apply_filters('RCB/Query/Arguments', \array_merge(['suppress_filters' => \false], $arguments), $context);
    }
    /**
     * Return the base URL to assets specially for Real Cookie Banner.
     *
     * @param string $path
     */
    public function getBaseAssetsUrl($path) {
        return \DevOwl\RealCookieBanner\Vendor\DevOwl\RealUtils\Core::getInstance()->getBaseAssetsUrl(
            'wp-real-cookie-banner/' . $path
        );
    }
    /**
     * Get config page.
     *
     * @codeCoverageIgnore
     */
    public function getConfigPage() {
        return $this->configPage;
    }
    /**
     * Get banner.
     *
     * @codeCoverageIgnore
     */
    public function getBanner() {
        return $this->banner;
    }
    /**
     * Get blocker.
     *
     * @codeCoverageIgnore
     */
    public function getBlocker() {
        return $this->blocker;
    }
    /**
     * Get request uuid 4.
     *
     * @codeCoverageIgnore
     */
    public function getPageRequestUuid4() {
        return $this->pageRequestUuid4;
    }
    /**
     * Get compatibility language class.
     *
     * @codeCoverageIgnore
     */
    public function getCompLanguage() {
        return $this->compLanguage;
    }
    /**
     * Get ad initiator from `real-utils`.
     *
     * @codeCoverageIgnore
     */
    public function getAdInitiator() {
        return $this->adInitiator;
    }
    /**
     * Get ad initiator from `real-product-manager-wp-client`.
     *
     * @codeCoverageIgnore
     */
    public function getRpmInitiator() {
        return $this->rpmInitiator;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getAnonymousAssetBuilder() {
        return $this->anonymousAssetBuilder;
    }
    /**
     * Get singleton core class.
     *
     * @return Core
     */
    public static function getInstance() {
        return !isset(self::$me) ? (self::$me = new \DevOwl\RealCookieBanner\Core()) : self::$me;
    }
}
// Inherited from packages/utils/src/Service
/**
 * See API docs.
 *
 * @api {get} /real-cookie-banner/v1/plugin Get plugin information
 * @apiHeader {string} X-WP-Nonce
 * @apiName GetPlugin
 * @apiGroup Plugin
 *
 * @apiSuccessExample {json} Success-Response:
 * {
 *     Name: "My plugin",
 *     PluginURI: "https://example.com/my-plugin",
 *     Version: "0.1.0",
 *     Description: "This plugin is doing something.",
 *     Author: "<a href="https://example.com">John Smith</a>",
 *     AuthorURI: "https://example.com",
 *     TextDomain: "my-plugin",
 *     DomainPath: "/languages",
 *     Network: false,
 *     Title: "<a href="https://example.com">My plugin</a>",
 *     AuthorName: "John Smith"
 * }
 * @apiVersion 1.0.0
 */
