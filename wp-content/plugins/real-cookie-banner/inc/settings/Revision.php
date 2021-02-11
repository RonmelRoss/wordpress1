<?php

namespace DevOwl\RealCookieBanner\settings;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\UserConsent;
use ReflectionClass;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Create a mechanism to catch all settings and create an unique revision.
 * Note: A revision holds any option in "raw", so there isn't any filter or
 * postprocess like a getter.
 */
class Revision {
    use UtilsProvider;
    const TABLE_NAME = 'revision';
    const TABLE_NAME_INDEPENDENT = 'revision_independent';
    const OPTION_PREFIX = 'SETTING_';
    const OPTION_NAME_CURRENT_HASH_PREFIX = RCB_OPT_PREFIX . '-revision-current-hash';
    const EXCLUDE_OPTIONS_FROM_HASH = [
        \DevOwl\RealCookieBanner\settings\General::SETTING_BANNER_ACTIVE,
        \DevOwl\RealCookieBanner\settings\General::SETTING_BLOCKER_ACTIVE,
        \DevOwl\RealCookieBanner\settings\General::SETTING_REFRESH_SITE_AFTER_CONSENT,
        \DevOwl\RealCookieBanner\settings\General::SETTING_HIDE_PAGE_IDS,
        \DevOwl\RealCookieBanner\settings\Consent::SETTING_RESPECT_DO_NOT_TRACK,
        \DevOwl\RealCookieBanner\settings\Consent::SETTING_SAVE_IP
    ];
    /**
     * Singleton instance.
     *
     * @var Revision
     */
    private static $me = null;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Get the current active revision. If there is not current revision (only after
     * activating the plugin itself), the current revision hash gets calculated from
     * initial settings.
     */
    public function getCurrentHash() {
        $hash = get_option($this->getCurrentHashOptionName(), '');
        if (empty($hash)) {
            $hash = $this->create(\true)['hash'];
        }
        return $hash;
    }
    /**
     * Create a MD5 hash from all available settings of Real Cookie Banner and save also as "current".
     * If the hash differs, a new consent is needed! Note also, that some settings are excluded and prevent
     * a retrigger. See also `createIndependent`.
     *
     * @param boolean $persist Persist the revision in database
     * @param boolean $forceNewConsent
     * @return array 'revision' and 'hash'
     */
    public function create($persist = \false, $forceNewConsent = \true) {
        global $wpdb;
        // Create hashable revision
        $revision = \array_merge(
            [
                'options' => $this->fromOptions(self::EXCLUDE_OPTIONS_FROM_HASH, \false),
                'groups' => \DevOwl\RealCookieBanner\Core::getInstance()
                    ->getBanner()
                    ->localizeGroups()
            ],
            $this->getContextVariables()
        );
        /**
         * Modify the revision array so specific data changes can cause a "Request new consent".
         *
         * @hook RCB/Revision/Array
         * @param {array} $result
         * @returns {array}
         */
        $revision = apply_filters('RCB/Revision/Array', $revision);
        $json_revision = \json_encode($revision);
        $hash = \md5($json_revision);
        $result = ['revision' => $revision, 'hash' => $hash];
        if ($persist) {
            $table_name = $this->getTableName(self::TABLE_NAME);
            $wpdb->query(
                // phpcs:disable WordPress.DB.PreparedSQL
                $wpdb->prepare(
                    "INSERT IGNORE INTO {$table_name} (json_revision, `hash`, created) VALUES (%s, %s, %s)",
                    $json_revision,
                    $hash,
                    current_time('mysql')
                )
            );
            if ($forceNewConsent) {
                update_option($this->getCurrentHashOptionName(), $hash, \true);
                /**
                 * A new consent is requested on the frontend. That means, the new revision
                 * hash is now present in the frontend.
                 *
                 * @hook RCB/Revision/Hash
                 * @param {array} $result
                 * @param {string} $hash Persisted hash to `wp_rcb_revision`
                 * @returns {array}
                 */
                return apply_filters('RCB/Revision/Hash', $result, $hash);
            }
        }
        return $result;
    }
    /**
     * Create a MD5 hash from all available customize settings of Real Cookie Banner.
     * UI changes does not trigger any reconsent!
     *
     * @param boolean $persist Persist the revision in database
     * @return array 'revision' and 'hash'
     */
    public function createIndependent($persist = \false) {
        global $wpdb;
        // Create hashable revision
        $revision = [
            'options' => $this->fromOptions(self::EXCLUDE_OPTIONS_FROM_HASH, \true),
            'banner' => \DevOwl\RealCookieBanner\Core::getInstance()
                ->getBanner()
                ->getCustomize()
                ->localizeValues(),
            'blocker' => \DevOwl\RealCookieBanner\Core::getInstance()
                ->getBlocker()
                ->localize()
        ];
        $json_revision = \json_encode($revision);
        $hash = \md5($json_revision);
        if ($persist) {
            $table_name = $this->getTableName(self::TABLE_NAME_INDEPENDENT);
            $wpdb->query(
                // phpcs:disable WordPress.DB.PreparedSQL
                $wpdb->prepare(
                    "INSERT IGNORE INTO {$table_name} (json_revision, `hash`, created) VALUES (%s, %s, %s)",
                    $json_revision,
                    $hash,
                    current_time('mysql')
                )
            );
        }
        return ['revision' => $revision, 'hash' => $hash];
    }
    /**
     * Get the current revision as array. It also includes the following infos:
     *
     * - `public_to_users`: The revision hash currently published to users
     * - `calculated`: The current revision hash from the latest settings
     * - `needs_retrigger`: If true, the consent revision can be updated with `create(true)`
     * - `has_gtm`: Has a cookie with a valid Google Tag Manager script (so you can show a notice in your config UI)
     * - `has_mtm`: Has a cookie with a valid Matomo Tag Manager script (so you can show a notice in your config UI)
     * - `public_count`: A total count of public cookies
     *
     * @param boolean $recreate If true, a new revision gets created so new consents need to be made. Always recreates when no consents are given yet.
     */
    public function getCurrent($recreate = \false) {
        $create = $this->create($recreate || \DevOwl\RealCookieBanner\UserConsent::getInstance()->getCount() === 0);
        $calculated = $create['hash'];
        $publicToUsers = $this->getCurrentHash();
        $tagManagerKeys = [
            'has_gtm' => \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_THIS_IS_GOOGLE_TAG,
            'has_mtm' => \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_THIS_IS_MATOMO_TAG
        ];
        $tagManagerResults = ['has_gtm' => \false, 'has_mtm' => \false];
        // Search for all available tag managers
        foreach ($tagManagerKeys as $key => $metaName) {
            $ids = get_posts(
                \DevOwl\RealCookieBanner\Core::getInstance()->queryArguments(
                    [
                        'post_type' => \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME,
                        'numberposts' => -1,
                        'nopaging' => \true,
                        'fields' => 'ids',
                        'meta_key' => $metaName,
                        'meta_value' => \true
                    ],
                    'revisionGetManagerIds'
                )
            );
            $tagManagerResults[$key] = \count($ids) > 0 ? $ids[0] : \false;
        }
        return \array_merge($create, $tagManagerResults, [
            'public_to_users' => $publicToUsers,
            'contexts' => $this->getPersistedContexts(),
            'calculated' => $calculated,
            'needs_retrigger' => $publicToUsers !== $calculated,
            'public_cookie_count' => \DevOwl\RealCookieBanner\settings\Cookie::getInstance()->getPublicCount(),
            'all_cookie_count' => \DevOwl\RealCookieBanner\settings\Cookie::getInstance()->getAllCount(),
            'all_blocker_count' => \DevOwl\RealCookieBanner\settings\Blocker::getInstance()->getAllCount(),
            'cookie_counts' => wp_count_posts(\DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME)
        ]);
    }
    /**
     * Get all persisted contexts so they can be used e. g. to query statistics.
     *
     * @return string[]
     */
    public function getPersistedContexts() {
        global $wpdb;
        $result = [];
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\UserConsent::TABLE_NAME);
        // phpcs:disable WordPress.DB.PreparedSQL
        $contexts = $wpdb->get_col("SELECT DISTINCT(context) FROM {$table_name}");
        // phpcs:enable WordPress.DB.PreparedSQL
        foreach ($contexts as $context) {
            $result[$context] = $this->translateContextVariablesString($context);
        }
        return $result;
    }
    /**
     * Read all available options. This does not impact the performance in any way,
     * because all `autoload=yes` options are loaded already.
     *
     * @param string[] $whiteBlackList Allows to skip / only options by option name
     * @param boolean $isInArray The needed result of `in_array` for `$whiteBlackList`
     * @param boolean $asOptionName If true, the returned map contains the option name instead of value
     */
    public function fromOptions($whiteBlackList = null, $isInArray = \false, $asOptionName = \false) {
        $clazzes = [
            \DevOwl\RealCookieBanner\settings\General::class,
            \DevOwl\RealCookieBanner\settings\Consent::class,
            \DevOwl\RealCookieBanner\settings\Multisite::class
        ];
        $options = [];
        foreach ($clazzes as $clazzName) {
            $clazz = new \ReflectionClass($clazzName);
            $constants = $clazz->getConstants();
            foreach ($constants as $key => $value) {
                if (
                    \substr($key, 0, \strlen(self::OPTION_PREFIX)) === self::OPTION_PREFIX &&
                    ($whiteBlackList === null ? \true : \in_array($value, $whiteBlackList, \true) === $isInArray)
                ) {
                    if (!$asOptionName) {
                        $optionName = $value;
                        /**
                         * Get a given option value by option name. This can be e. g. useful for WPML
                         * so original post ID's gets transformed to the current active language post id.
                         *
                         * @hook RCB/Revision/Option/$optionName
                         * @param {mixed} $value
                         * @return {mixed}
                         */
                        $value = apply_filters('RCB/Revision/Option/' . $optionName, get_option($value));
                    }
                    $options[$key] = $value;
                }
            }
        }
        return $options;
    }
    /**
     * See filter RCB/Revision/Context.
     *
     * @param boolean $implicit If `true`, implicit context variables are parsed
     */
    public function getContextVariables($implicit = \false) {
        if ($implicit) {
            /**
             * Get implicit context relevant options like blog id. Implicit context variables are not populated
             * to the context, nor to the revision. Use this only if you want to modify the cookie name!
             *
             * Warning: Cookie names cannot contain any of the following '=,; \t\r\n\013\014', so please make
             * sure such characters are not stored in your value (if so, they get replaced with underscore `_`).
             *
             * @hook RCB/Revision/Context/Implicit
             * @param {array} $context
             * @return {array}
             */
            return apply_filters('RCB/Revision/Context/Implicit', [
                // Add current blog ID to keep multisite intact (https://stackoverflow.com/q/4056306/5506547)
                'blog' => get_current_blog_id()
            ]);
        } else {
            /**
             * Get context relevant options like language code (WPML, PolyLang). If the language
             * changes, a new revision will be created or requested so they are completely independent.
             * They also get populated to the generated revision.
             *
             * Warning: Cookie names cannot contain any of the following '=,; \t\r\n\013\014', so please make
             * sure such characters are not stored in your value (if so, they get replaced with underscore `_`).
             *
             * @hook RCB/Revision/Context
             * @param {array} $context
             * @return {array}
             */
            return apply_filters('RCB/Revision/Context', []);
        }
    }
    /**
     * Get context relevant options as string so they can be used as cookie name or option name.
     *
     * @param boolean $implicit If `true`, implicit context variables are parsed
     */
    public function getContextVariablesString($implicit = \false) {
        $value = \json_encode($this->getContextVariables($implicit));
        $value = \str_replace(['{', '"', '}', '[', ']'], '', $value);
        // Warning: Cookie names cannot contain any of the following '=,; \t\r\n\013\014'
        $value = \str_replace(['=', ',', ';'], '_', $value);
        return $value;
    }
    /**
     * See filter RCB/Revision/Context/Translate.
     *
     * @param string $context
     * @return string
     */
    public function translateContextVariablesString($context) {
        /**
         * Translate a context variable string to human readable form. E. g. replace `lang:de` with `Sprache: Deutsch`
         *
         * @hook RCB/Revision/Context/Translate
         * @param {string} $context
         * @return {string}
         */
        return apply_filters('RCB/Revision/Context/Translate', $context);
    }
    /**
     * Get the option for the current hash option name in `wp_options`.
     */
    public function getCurrentHashOptionName() {
        return self::OPTION_NAME_CURRENT_HASH_PREFIX . '-' . $this->getContextVariablesString();
    }
    /**
     * Get the revision(s) by hash(es).
     *
     * @param string|string[] $hash
     * @param boolean $independent
     */
    public function getByHash($hash, $independent = \false) {
        global $wpdb;
        $table_name = $this->getTableName($independent ? self::TABLE_NAME_INDEPENDENT : self::TABLE_NAME);
        if (\is_array($hash)) {
            // Read multiple
            $hashes = \array_map('sanitize_key', \array_unique($hash));
            $result = [];
            // phpcs:disable WordPress.DB.PreparedSQL
            $rows = $wpdb->get_results(
                \sprintf(
                    "SELECT `hash`, json_revision FROM {$table_name} WHERE `hash` IN ('%s')",
                    \join("','", $hashes)
                ),
                ARRAY_A
            );
            // phpcs:enable WordPress.DB.PreparedSQL
            // Zip to key value map
            foreach ($rows as $key => $value) {
                $result[$value['hash']] = \json_decode($value['json_revision'], ARRAY_A);
                unset($rows[$key]);
            }
            return $result;
        } else {
            // Read single
            // phpcs:disable WordPress.DB.PreparedSQL
            $row = $wpdb->get_var($wpdb->prepare("SELECT json_revision FROM {$table_name} WHERE `hash` = %s", $hash));
            // phpcs:enable WordPress.DB.PreparedSQL
            return $row === null ? null : \json_decode($row, ARRAY_A);
        }
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\settings\Revision()) : self::$me;
    }
}
