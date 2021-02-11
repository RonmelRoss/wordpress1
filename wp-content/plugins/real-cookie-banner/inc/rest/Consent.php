<?php

namespace DevOwl\RealCookieBanner\rest;

use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Service;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\Clear;
use DevOwl\RealCookieBanner\IpHandler;
use DevOwl\RealCookieBanner\MyConsent;
use DevOwl\RealCookieBanner\UserConsent;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Consent API
 */
class Consent {
    use UtilsProvider;
    const CONSENT_ALL_ITEMS_PER_PAGE = 10;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Register endpoints.
     */
    public function rest_api_init() {
        $namespace = \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Service::getNamespace($this);
        register_rest_route($namespace, '/consent/all', [
            'methods' => 'GET',
            'callback' => [$this, 'routeGetAll'],
            'permission_callback' => [$this, 'permission_callback'],
            'args' => [
                'offset' => ['type' => 'number', 'required' => \true],
                'per_page' => ['type' => 'number'],
                'uuid' => ['type' => 'string'],
                'ip' => ['type' => 'string']
            ]
        ]);
        register_rest_route($namespace, '/consent/all', [
            'methods' => 'DELETE',
            'callback' => [$this, 'routeDeleteAll'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/consent/clear', [
            'methods' => 'DELETE',
            'callback' => [$this, 'routeDeleteClear'],
            'permission_callback' => '__return_true',
            'args' => ['cookies' => ['type' => 'string', 'required' => \true]]
        ]);
        register_rest_route($namespace, '/consent', [
            'methods' => 'GET',
            'callback' => [$this, 'routeGet'],
            'permission_callback' => '__return_true'
        ]);
        register_rest_route($namespace, '/consent', [
            'methods' => 'POST',
            'callback' => [$this, 'routePost'],
            'permission_callback' => '__return_true',
            'args' => [
                'markAsDoNotTrack' => ['type' => 'boolean', 'default' => \false],
                // Also ported to wp-api/consent.post.tsx
                'buttonClicked' => [
                    'type' => 'string',
                    'enum' => \DevOwl\RealCookieBanner\UserConsent::CLICKABLE_BUTTONS,
                    'required' => \true
                ],
                // Content Blocker ID
                'blocker' => ['type' => 'number', 'default' => 0],
                'viewPortWidth' => ['type' => 'number', 'default' => 0],
                'viewPortHeight' => ['type' => 'number', 'default' => 0]
            ]
        ]);
    }
    /**
     * Check if user is allowed to call this service requests.
     */
    public function permission_callback() {
        return current_user_can(\DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY);
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {get} /real-cookie-banner/v1/consent/all Get all consent entries
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {number} offset
     * @apiParam {number} [per_page=10]
     * @apiParam {string} [uuid]
     * @apiParam {string} [ip]
     * @apiName GetAll
     * @apiGroup Consent
     * @apiVersion 1.0.0
     * @apiPermission manage_options
     */
    public function routeGetAll($request) {
        // Validate parameters
        $limitOffset = $request->get_param('offset');
        $limitOffset = $limitOffset >= 0 ? $limitOffset : 0;
        $perPage = $request->get_param('per_page');
        $perPage =
            isset($perPage) && $perPage >= 1 && $perPage <= 100 ? \intval($perPage) : self::CONSENT_ALL_ITEMS_PER_PAGE;
        $uuid = $request->get_param('uuid');
        $ip = $request->get_param('ip');
        return new \WP_REST_Response([
            'count' => \DevOwl\RealCookieBanner\UserConsent::getInstance()->getCount(),
            'items' => \DevOwl\RealCookieBanner\UserConsent::getInstance()->byCriteria([
                'offset' => $limitOffset,
                'perPage' => $perPage,
                'uuid' => $uuid,
                'ip' => $ip
            ])
        ]);
    }
    /**
     * See API docs.
     *
     * @api {delete} /real-cookie-banner/v1/consent/all Delete all consent entries (including revisions)
     * @apiHeader {string} X-WP-Nonce
     * @apiName DeleteAll
     * @apiGroup Consent
     * @apiVersion 1.0.0
     * @apiPermission manage_options
     */
    public function routeDeleteAll() {
        return new \WP_REST_Response(\DevOwl\RealCookieBanner\UserConsent::getInstance()->purge());
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {delete} /real-cookie-banner/v1/consent/clear Delete server-side cookies like `http` by cookie ids
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {string} cookies A comma separated list of cookie ids which should be opt-out
     * @apiName DeleteClear
     * @apiGroup Consent
     * @apiVersion 1.0.0
     */
    public function routeDeleteClear($request) {
        $cookies = \array_map('intval', \explode(',', $request->get_param('cookies')));
        return new \WP_REST_Response(\DevOwl\RealCookieBanner\Clear::getInstance()->byCookies($cookies));
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {get} /real-cookie-banner/v1/consent Get the last 100 consent entries for the current user
     * @apiHeader {string} X-WP-Nonce
     * @apiName Get
     * @apiGroup Consent
     * @apiVersion 1.0.0
     */
    public function routeGet($request) {
        return new \WP_REST_Response(\DevOwl\RealCookieBanner\MyConsent::getInstance()->getCurrentHistory());
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {post} /real-cookie-banner/v1/consent Create or update an existing consent
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {array} groups
     * @apiParam {string} buttonClicked
     * @apiParam {boolean} [markAsDoNotTrack]
     * @apiParam {number} [viewPortWidth=0]
     * @apiParam {number} [viewPortHeight=0]
     * @apiParam {number} [blocker=0]
     * @apiName Create
     * @apiGroup Consent
     * @apiVersion 1.0.0
     */
    public function routePost($request) {
        $markAsDoNotTrack = $request->get_param('markAsDoNotTrack');
        $buttonClicked = $request->get_param('buttonClicked');
        $viewPortWidth = $request->get_param('viewPortWidth');
        $viewPortHeight = $request->get_param('viewPortHeight');
        $blocker = $request->get_param('blocker');
        $referer = wp_get_raw_referer();
        if (\DevOwl\RealCookieBanner\IpHandler::getInstance()->isFlooding()) {
            return new \WP_Error('rest_rcb_forbidden');
        }
        $persist = \DevOwl\RealCookieBanner\MyConsent::getInstance()->persist(
            $request->get_param('groups'),
            $markAsDoNotTrack,
            $buttonClicked,
            $viewPortWidth,
            $viewPortHeight,
            $referer,
            $blocker
        );
        if (is_wp_error($persist)) {
            return $persist;
        }
        /**
         * An user has given a new consent. With this filter you can add additional response
         * to the REST API. Internally this is used e. g. for Consent Forwarding.
         *
         * @hook RCB/Consent/Created/Response
         * @param {array} $result
         * @param {WP_REST_Request} $request
         * @return {array}
         */
        return new \WP_REST_Response(apply_filters('RCB/Consent/Created/Response', $persist, $request));
    }
    /**
     * New instance.
     */
    public static function instance() {
        return new \DevOwl\RealCookieBanner\rest\Consent();
    }
}
