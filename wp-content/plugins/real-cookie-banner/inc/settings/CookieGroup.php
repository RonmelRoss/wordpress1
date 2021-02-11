<?php

namespace DevOwl\RealCookieBanner\settings;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\view\Banner;
use WP_Error;
use WP_REST_Terms_Controller;
use WP_Term;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Register cookie group taxonomy.
 */
class CookieGroup {
    use UtilsProvider;
    const TAXONOMY_NAME = 'rcb-cookie-group';
    const META_NAME_ORDER = 'order';
    const META_NAME_IS_ESSENTIAL = 'isEssential';
    const SYNC_META_COPY_AND_COPY_ONCE = [
        \DevOwl\RealCookieBanner\settings\CookieGroup::META_NAME_IS_ESSENTIAL,
        \DevOwl\RealCookieBanner\settings\CookieGroup::META_NAME_ORDER
    ];
    const SYNC_OPTIONS = [
        'meta' => [
            'copy' => \DevOwl\RealCookieBanner\settings\CookieGroup::SYNC_META_COPY_AND_COPY_ONCE,
            'copy-once' => \DevOwl\RealCookieBanner\settings\CookieGroup::SYNC_META_COPY_AND_COPY_ONCE
        ]
    ];
    const META_KEYS = [\DevOwl\RealCookieBanner\settings\CookieGroup::META_NAME_IS_ESSENTIAL];
    /**
     * Singleton instance.
     *
     * @var CookieGroup
     */
    private static $me = null;
    private $cacheGetOrdered = [];
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Register custom taxonomy.
     */
    public function register() {
        $labels = ['name' => __('Cookie Groups', RCB_TD), 'singular_name' => __('Cookie Group', RCB_TD)];
        $args = [
            'label' => $labels['name'],
            'labels' => $labels,
            'public' => \false,
            'publicly_queryable' => \false,
            'hierarchical' => \false,
            'show_ui' => \true,
            'show_in_menu' => \false,
            'show_in_nav_menus' => \false,
            'query_var' => \true,
            'rewrite' => \false,
            'show_admin_column' => \false,
            'show_in_rest' => \true,
            'capabilities' => [
                'manage_terms' => \DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY,
                'edit_terms' => \DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY,
                'delete_terms' => \DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY,
                'assign_terms' => \DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY
            ],
            'rest_base' => self::TAXONOMY_NAME,
            'rest_controller_class' => \WP_REST_Terms_Controller::class,
            'show_in_quick_edit' => \false
        ];
        register_taxonomy(self::TAXONOMY_NAME, [\DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME], $args);
        register_meta('term', self::META_NAME_ORDER, [
            'object_subtype' => self::TAXONOMY_NAME,
            'type' => 'number',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('term', self::META_NAME_IS_ESSENTIAL, [
            'object_subtype' => self::TAXONOMY_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
    }
    /**
     * Ensures the "Essentials" term exists. Make sure to create the temporary text domain.
     */
    public function ensureEssentialGroupCreated() {
        $term = $this->getEssentialGroup();
        if ($term === null) {
            $result = wp_insert_term(
                __('Essential', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                self::TAXONOMY_NAME,
                [
                    'description' => __(
                        'Essential cookies are required for the basic functionality of the website. They only contain technically necessary cookies.',
                        \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                    )
                ]
            );
            update_term_meta($result['term_id'], self::META_NAME_ORDER, 0);
            update_term_meta($result['term_id'], self::META_NAME_IS_ESSENTIAL, \true);
            $this->createNonEssentialDefaults();
        }
    }
    /**
     * Create all default terms expect "Essential".
     */
    protected function createNonEssentialDefaults() {
        $result = wp_insert_term(
            __('Functional', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            self::TAXONOMY_NAME,
            [
                'description' => __(
                    'Functional cookies are necessary to provide features beyond the essential functionality such as prettier fonts, video playback or interactive Web 2.0 features. Content from e. g. video platforms and social media platforms is blocked by default, and you can agree to the individual services. If you agree to these cookies, this content will be loaded automatically without further manual consent.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                )
            ]
        );
        update_term_meta($result['term_id'], self::META_NAME_ORDER, 1);
        $result = wp_insert_term(
            __('Statistic', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            self::TAXONOMY_NAME,
            [
                'description' => __(
                    'Statistic cookies are needed to collect pseudonymous data about the visitors of the website. The data enables us to understand visitors better and to optimize the website.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                )
            ]
        );
        update_term_meta($result['term_id'], self::META_NAME_ORDER, 2);
        $result = wp_insert_term(
            __('Marketing', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            self::TAXONOMY_NAME,
            [
                'description' => __(
                    'Marketing cookies are used by us and third parties to record the behaviour of individual users, analyse the data collected and, for example, display personalised advertisements. These cookies enable us to track users across multiple websites.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                )
            ]
        );
        update_term_meta($result['term_id'], self::META_NAME_ORDER, 3);
    }
    /**
     * A cookie group got deleted, also delete all associated cookies.
     *
     * @param int $term
     * @param int $tt_id
     * @param object $deleted_term
     * @param int[] $object_ids
     */
    public function deleted($term, $tt_id, $deleted_term, $object_ids) {
        foreach ($object_ids as $id) {
            wp_delete_post($id, \true);
        }
    }
    /**
     * Get all available cookie groups ordered.
     *
     * @param boolean $force
     * @return WP_Term[]|WP_Error
     */
    public function getOrdered($force = \false) {
        $context = \DevOwl\RealCookieBanner\settings\Revision::getInstance()->getContextVariablesString();
        if ($force === \false && isset($this->cacheGetOrdered[$context])) {
            return $this->cacheGetOrdered[$context];
        }
        // Read all including hidden, only the essential term may be empty
        $terms = [];
        $includingHidden = get_terms(
            \DevOwl\RealCookieBanner\Core::getInstance()->queryArguments(
                [
                    'taxonomy' => self::TAXONOMY_NAME,
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                    'hide_empty' => \false,
                    'meta_query' => [['key' => self::META_NAME_ORDER, 'type' => 'NUMERIC']]
                ],
                'cookieGroupsGetOrdered'
            )
        );
        // Filter hidden
        foreach ($includingHidden as $term) {
            if ($term->count > 0 || get_term_meta($term->term_id, self::META_NAME_IS_ESSENTIAL)) {
                $terms[] = $term;
            }
        }
        foreach ($terms as &$term) {
            $term->metas = [];
            foreach (self::META_KEYS as $meta_key) {
                $metaValue = get_term_meta($term->term_id, $meta_key, \true);
                switch ($meta_key) {
                    case self::META_NAME_IS_ESSENTIAL:
                        $metaValue = \boolval($metaValue);
                        break;
                    default:
                        break;
                }
                $term->metas[$meta_key] = $metaValue;
            }
        }
        $this->cacheGetOrdered[$context] = $terms;
        return $terms;
    }
    /**
     * Get the WP_Term of the essential group.
     *
     * @param boolean $force If `true`, cache will be invalidated
     * @return WP_Term|null
     */
    public function getEssentialGroup($force = \false) {
        $terms = $this->getOrdered($force);
        foreach ($terms as $term) {
            if ($term->metas[self::META_NAME_IS_ESSENTIAL]) {
                return $term;
            }
        }
        return null;
    }
    /**
     * Get singleton instance.
     *
     * @return CookieGroup
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\settings\CookieGroup()) : self::$me;
    }
}
