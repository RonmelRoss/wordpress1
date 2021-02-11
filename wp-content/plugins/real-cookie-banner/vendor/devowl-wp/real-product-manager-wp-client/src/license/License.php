<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\license;

use DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\client\ClientUtils;
use DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\Core;
use DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\UtilsProvider;
use WP_Error;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Handle license information for a given plugin and associated blog id.
 */
class License {
    use UtilsProvider;
    const OPTION_NAME_CODE_PREFIX = RPM_WP_CLIENT_OPT_PREFIX . '-code_';
    const OPTION_NAME_UUID_PREFIX = RPM_WP_CLIENT_OPT_PREFIX . '-uuid_';
    const OPTION_NAME_TELEMETRY_PREFIX = RPM_WP_CLIENT_OPT_PREFIX . '-telemetry_';
    const OPTION_NAME_INSTALLATION_TYPE_PREFIX = RPM_WP_CLIENT_OPT_PREFIX . '-installationType_';
    const OPTION_NAME_HINT_PREFIX = RPM_WP_CLIENT_OPT_PREFIX . '-hint_';
    const INSTALLATION_TYPE_NONE = \false;
    const INSTALLATION_TYPE_DEVELOPMENT = 'development';
    const INSTALLATION_TYPE_PRODUCTION = 'production';
    const ERROR_CODE_NOT_ACTIVATED = 'rpm_wpc_not_activated';
    /**
     * Plugin slug.
     *
     * @var string
     */
    private $slug;
    /**
     * Blog id for this license.
     *
     * @var int
     */
    private $blogId;
    /**
     * License activation handler.
     *
     * @var LicenseActivation
     */
    private $activation;
    /**
     * Remote status of the activation.
     *
     * @var WP_Error|array
     */
    private $remoteStatus;
    /**
     * C'tor.
     *
     * @param string $slug
     * @param int $blogId
     * @codeCoverageIgnore
     */
    public function __construct($slug, $blogId) {
        $this->slug = $slug;
        $this->blogId = $blogId;
        $this->activation = new \DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\license\LicenseActivation(
            $this
        );
    }
    /**
     * Switch to this blog.
     *
     * @see https://developer.wordpress.org/reference/functions/switch_to_blog/
     */
    public function switch() {
        if (\function_exists('switch_to_blog')) {
            switch_to_blog($this->getBlogId());
        }
    }
    /**
     * Restore to previous blog.
     *
     * @see https://developer.wordpress.org/reference/functions/restore_current_blog/
     */
    public function restore() {
        if (\function_exists('restore_current_blog')) {
            restore_current_blog();
        }
    }
    /**
     * Sync our plugin version, PHP version and WordPress version with our remote system.
     */
    public function syncWithRemote() {
        $activation = $this->getActivation();
        $code = $activation->getCode();
        if (empty($code)) {
            return new \WP_Error(
                \DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\license\License::ERROR_CODE_NOT_ACTIVATED,
                __('You have not yet activated a license for this plugin on your website.', RPM_WP_CLIENT_TD),
                ['blog' => $this->getBlogId(), 'slug' => $this->getSlug()]
            );
        }
        $response = $this->getClient()->patch($code, $this->getUuid());
        $this->validateRemoteResponse($response);
        return $response;
    }
    /**
     * Fetch remote status from the Real Product Manager server. Automatically
     * validates with `#validateRemoteResponse`, too.
     *
     * @param boolean $force
     */
    public function fetchRemoteStatus($force = \false) {
        // Not yet activated, it's an error when asking for remote result
        $code = $this->getActivation()->getCode();
        if (empty($code)) {
            return new \WP_Error(
                self::ERROR_CODE_NOT_ACTIVATED,
                __('You have not yet activated a license for this plugin on your website.', RPM_WP_CLIENT_TD),
                ['blog' => $this->getBlogId(), 'slug' => $this->getSlug()]
            );
        }
        if ($this->remoteStatus === null || $force) {
            $this->remoteStatus = $this->getClient()->get($code, $this->getUuid());
            $this->validateRemoteResponse($this->remoteStatus);
        }
        return $this->remoteStatus;
    }
    /**
     * Validate a remote response against their body and probably an error code.
     * It automatically revokes the license if expired/revoked remotely.
     *
     * @param WP_Error|array $response
     */
    public function validateRemoteResponse($response) {
        if (
            is_wp_error($response) &&
            $response->get_error_code() ===
                \DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\client\ClientUtils::ERROR_CODE_REMOTE
        ) {
            $errorCodes = $response->get_error_codes();
            $errors = $response->get_error_messages();
            foreach ($errorCodes as $index => $errorCode) {
                switch ($errorCode) {
                    case 'ClientNotFound':
                    case 'LicenseActivationNotFound':
                    case 'LicenseHasBeenExpired':
                    case 'LicenseHasBeenRevoked':
                    case 'LicenseNotFound':
                        $this->getActivation()->deactivate(
                            'warning',
                            \sprintf('%s (%s)', $errors[$index], $this->getActivation()->getCode())
                        );
                        return \false;
                    default:
                        break;
                }
            }
        }
        return \true;
    }
    /**
     * Get initiator.
     */
    public function getInitiator() {
        return \DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\Core::getInstance()->getInitiator(
            $this->getSlug()
        );
    }
    /**
     * Get blog name for this license.
     */
    public function getBlogName() {
        $this->switch();
        $result = get_bloginfo('name');
        $this->restore();
        return $result;
    }
    /**
     * Get known UUID. Can be empty if none given. The UUID will be set with the first
     * license activation.
     *
     * @return string
     */
    public function getUuid() {
        $this->switch();
        $result = get_option(self::OPTION_NAME_UUID_PREFIX . $this->getSlug(), '');
        $this->restore();
        return $result;
    }
    /**
     * Get installation type from remote status. Can be `false` if none given.
     *
     * @return string|false
     */
    public function getInstallationType() {
        $status = $this->fetchRemoteStatus();
        if (is_wp_error($status)) {
            return \false;
        }
        return $status['licenseActivation']['type'];
    }
    /**
     * Get license activation handler.
     *
     * @codeCoverageIgnore
     */
    public function getActivation() {
        return $this->activation;
    }
    /**
     * Get plugin slug.
     *
     * @codeCoverageIgnore
     */
    public function getSlug() {
        return $this->slug;
    }
    /**
     * Get license client.
     */
    public function getClient() {
        return $this->getInitiator()
            ->getPluginUpdater()
            ->getLicenseActivationClient();
    }
    /**
     * Get the license as array, useful for frontend needs or REST API.
     */
    public function getAsArray() {
        $remote = $this->fetchRemoteStatus();
        return [
            'blog' => $this->getBlogId(),
            'blogName' => $this->getBlogName(),
            'installationType' => $this->getInstallationType(),
            'code' => $this->getActivation()->getCode(),
            'hint' => $this->getActivation()->getHint(),
            'remote' => is_wp_error($remote) ? null : $remote
        ];
    }
    /**
     * Get blog id.
     *
     * @codeCoverageIgnore
     */
    public function getBlogId() {
        return $this->blogId;
    }
}
