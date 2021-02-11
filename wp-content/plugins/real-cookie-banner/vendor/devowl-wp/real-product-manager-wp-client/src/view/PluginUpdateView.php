<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\view;

use DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\Core;
use DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\PluginUpdate;
use DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\UtilsProvider;
use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Service;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Plugin update view handling. E. g. add links to the plugins row in plugins list.
 */
class PluginUpdateView {
    use UtilsProvider;
    const OPTION_NAME_ADMIN_NOTICE_LICENSE_DISMISSED_DAY_PREFIX =
        RPM_WP_CLIENT_OPT_PREFIX . '-noticeLicenseDismissDay_';
    const CLICK_HANDLER_ATTRIBUTE = 'data-rpm-wp-client-plugin-update';
    const CLICK_NOTICE_LICENSE_DISMISS_HANDLER_ATTRIBUTE = 'data-rpm-wp-client-plugin-update-license-notice-dismiss';
    const HASH_HANDLER_PREFIX = 'rpm-wp-client-plugin-update-';
    /**
     * Plugin update instance.
     *
     * @var PluginUpdate
     */
    private $pluginUpdate;
    /**
     * C'tor.
     *
     * @param PluginUpdate $pluginUpdate
     * @codeCoverageIgnore
     */
    private function __construct($pluginUpdate) {
        $this->pluginUpdate = $pluginUpdate;
    }
    /**
     * Show a notice when the plugin is not fully licensed.
     */
    public function admin_notices_not_licensed() {
        $initiator = $this->getPluginUpdate()->getInitiator();
        $screen = get_current_screen();
        $isUpdateCorePage = $screen->id === 'update-core';
        if (current_user_can('install_plugins') && ($initiator->isAdminNoticeLicenseVisible() || $isUpdateCorePage)) {
            $text = $this->getAdminNoticeLicenseText($isUpdateCorePage);
            if ($text !== \false) {
                // Create dismiss option so every day can be dismissed
                $dismissDayOptionName =
                    self::OPTION_NAME_ADMIN_NOTICE_LICENSE_DISMISSED_DAY_PREFIX . $initiator->getPluginSlug();
                $dismissDay = \intval(get_option($dismissDayOptionName));
                if ($dismissDay === \false) {
                    add_option($dismissDayOptionName, 0);
                    $dismissDay = 0;
                }
                // Do not show notice if dismissed
                $daysSince = $this->getPluginUpdate()->getDaysSinceFirstInitialization();
                if ($dismissDay < $daysSince) {
                    echo '<div class="notice notice-warning" style="padding-right:38px;position:relative;"><p>' .
                        $text[1] .
                        '</p></div>';
                }
            }
        }
    }
    /**
     * Show a notice in the plugins list that the plugin is not activated, yet.
     */
    public function after_plugin_row() {
        $wp_list_table = _get_list_table('WP_Plugins_List_Table');
        \printf(
            '<tr class="active">
	<th colspan="%d" class="check-column" style="padding:0;">
    	<div class="plugin-update update-message notice inline notice-warning notice-alt" style="margin:10px 20px 10px 26px;border-top:1px solid #ffb900;box-shadow:4px 4px 4px #ffb9001a, 1px 1px 0px #ffb900;">
        	<div class="update-message"><p style="margin:0;">%s</p></div>
    	</div>
    </th>
</tr>',
            $wp_list_table->get_column_count(),
            // translators:
            \sprintf(
                '<strong>%s</strong> %s',
                __('You have not yet entered the license key.', RPM_WP_CLIENT_TD),
                $this->generateLicenseLink(__('Activate license to receive automatic updates.', RPM_WP_CLIENT_TD))
            )
        );
    }
    /**
     * Generate a `<a` link to open the license form for a given plugin.
     *
     * @param string $text
     */
    public function generateLicenseLink($text) {
        return \sprintf(
            '<a href="#" %s="%s">%s</a>',
            self::CLICK_HANDLER_ATTRIBUTE,
            $this->getPluginUpdate()
                ->getInitiator()
                ->getPluginSlug(),
            $text
        );
    }
    /**
     * Add a "Enter License" link to the plugins actions.
     *
     * @param array $actions The plugin actions
     * @return array The updated actions.
     */
    public function plugin_action_links($actions) {
        // Free version should never show a license button in plugins list
        if (
            !$this->getPluginUpdate()
                ->getInitiator()
                ->isExternalUpdateEnabled()
        ) {
            return $actions;
        }
        $link = $this->generateLicenseLink(__('License', RPM_WP_CLIENT_TD));
        $actions[RPM_WP_CLIENT_SLUG] = $this->getPluginUpdate()->isLicensed()
            ? $link
            : \sprintf('<span style="font-weight:bold;">%s</span>', $link);
        return $actions;
    }
    /**
     * Dismiss the license admin notice for the current day.
     */
    public function dismissLicenseAdminNotice() {
        $day = $this->getPluginUpdate()->getDaysSinceFirstInitialization();
        return update_option(
            self::OPTION_NAME_ADMIN_NOTICE_LICENSE_DISMISSED_DAY_PREFIX .
                $this->getPluginUpdate()
                    ->getInitiator()
                    ->getPluginSlug(),
            $day
        );
    }
    /**
     * Get the admin notice text for not-fully licensed plugins. Returns `false` if the admin
     * notice should not be shown. Returns `[true, 'text']` if a notice should be shown and is dismissible.
     * Returns `[false, 'text']` for a permanent notice.
     *
     * @param boolean $allowFirstDays If `true`, the first and second day also shows a notice. Useful for `update-core` page
     */
    protected function getAdminNoticeLicenseText($allowFirstDays = \false) {
        $days = $this->getPluginUpdate()->getDaysSinceFirstInitialization();
        $dismissible = \true;
        // translators:
        $text = __(
            'You have not yet activated a license for the plugin %s. Activate license to receive automatic updates.',
            RPM_WP_CLIENT_TD
        );
        switch ($days) {
            case 1:
            case 2:
                if ($allowFirstDays) {
                    break;
                } else {
                    return \false;
                }
            case 3:
                break;
            case 4:
                // translators:
                $text = __(
                    'Updates of %s are waiting for you when you activate your license. Activate your license in the settings now!',
                    RPM_WP_CLIENT_TD
                );
                break;
            case 5:
                // translators:
                $text = __('Activate your %s to use all features with great support. Activate now!', RPM_WP_CLIENT_TD);
                break;
            case 6:
                // translators:
                $text = __(
                    'You still have not activated your %s license. Activate your license now in the settings!',
                    RPM_WP_CLIENT_TD
                );
                break;
            case 7:
                // translators:
                $text = __(
                    'You are not allowed to use %s according to our license terms unless you have purchased a license. Activate in the settings or buy now!',
                    RPM_WP_CLIENT_TD
                );
                break;
            case 8:
                $dismissible = \false;
                // translators:
                $text = __(
                    'Attention! Pirates distribute %s for free without a license. Activate your license in the settings to show that you are not a pirate!',
                    RPM_WP_CLIENT_TD
                );
                break;
            case 9:
                $dismissible = \false;
                // translators:
                $text = __(
                    'You are probably using an illegally purchased copy of %s without a license. Check your license now!',
                    RPM_WP_CLIENT_TD
                );
                break;
            default:
                $dismissible = \false;
                // translators:
                $text = __(
                    'You are probably using an illegal copy of %s. Purchase a license now or activate your license in the settings and continue using this software with a clear conscience!',
                    RPM_WP_CLIENT_TD
                );
                break;
        }
        $initiator = $this->getPluginUpdate()->getInitiator();
        $activateLink = \sprintf(
            ' &bull; <a href="%s">%s</a>',
            admin_url('plugins.php#' . self::HASH_HANDLER_PREFIX . $initiator->getPluginSlug()),
            __('Activate now', RPM_WP_CLIENT_TD)
        );
        $dismissLink = $dismissible
            ? \sprintf(
                '<button type="button" class="notice-dismiss" href="#" onClick="%s"></button>',
                esc_js($this->dismissOnClickHandler($initiator->getPluginSlug()))
            )
            : '';
        return [
            $dismissible,
            \sprintf($text, \sprintf('<strong>%s</strong>', $initiator->getPluginName())) . $activateLink . $dismissLink
        ];
    }
    /**
     * Dismiss-functionality is handled through a inline-onclick handler because we
     * do not need to enqueue an extra script on each page.
     *
     * @param string $slug
     */
    protected function dismissOnClickHandler($slug) {
        return \join('', [
            'jQuery(this).parents(".notice").remove();',
            \sprintf(
                'window.fetch("%s");',
                add_query_arg(
                    ['_method' => 'DELETE', '_wpnonce' => wp_create_nonce('wp_rest')],
                    \sprintf(
                        '%splugin-update/%s/license-notice',
                        \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Service::getUrl(
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\Core::getInstance()
                        ),
                        $slug
                    )
                )
            )
        ]);
    }
    /**
     * Get plugin update instance.
     *
     * @codeCoverageIgnore
     */
    public function getPluginUpdate() {
        return $this->pluginUpdate;
    }
    /**
     * New instance.
     *
     * @param PluginUpdate $pluginUpdate
     * @codeCoverageIgnore
     */
    public static function instance($pluginUpdate) {
        return new \DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\view\PluginUpdateView(
            $pluginUpdate
        );
    }
}
