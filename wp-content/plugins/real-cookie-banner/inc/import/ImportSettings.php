<?php

namespace DevOwl\RealCookieBanner\import;

use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\settings\Multisite;
use DevOwl\RealCookieBanner\settings\Revision;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Trait to handle the importer for settings in the `Import` class.
 */
trait ImportSettings {
    /**
     * Import settings from JSON.
     *
     * @param array $settings
     */
    protected function doImportSettings($settings) {
        $availableOptions = \DevOwl\RealCookieBanner\settings\Revision::getInstance()->fromOptions(null, \false, \true);
        $availableOptionKeys = \array_keys($availableOptions);
        foreach ($settings as $key => $value) {
            if (\in_array($key, $availableOptionKeys, \true)) {
                $optionName = $availableOptions[$key];
                // Skip already persistent options with the same value (no strict comparision)
                // phpcs:disable WordPress.PHP.StrictComparisons
                if (get_option($optionName) == $value) {
                    continue;
                }
                // phpcs:enable WordPress.PHP.StrictComparisons
                // Check for special cases and abort it
                if (!$this->handleSepcialSetting($optionName, $value, $key)) {
                    continue;
                }
                // Handle update
                if (!update_option($optionName, $value)) {
                    $this->addMessageUpdateOptionFailure($optionName);
                }
            } else {
                $this->addMessageOptionOutdated($key);
            }
        }
    }
    /**
     * Handle special cases for settings.
     *
     * @param string $optionName
     * @param mixed $value
     * @param string $key
     */
    protected function handleSepcialSetting($optionName, $value, $key) {
        $onlyPro = \false;
        switch ($optionName) {
            case \DevOwl\RealCookieBanner\settings\General::SETTING_IMPRINT_ID:
            case \DevOwl\RealCookieBanner\settings\General::SETTING_PRIVACY_POLICY_ID:
            case \DevOwl\RealCookieBanner\settings\General::SETTING_HIDE_PAGE_IDS:
                if ($value > 0 || !empty($value)) {
                    $this->addMessageOptionRelatesPageId(
                        ($optionName === \DevOwl\RealCookieBanner\settings\General::SETTING_PRIVACY_POLICY_ID
                                ? __('Privacy policy page', RCB_TD)
                                : $optionName === \DevOwl\RealCookieBanner\settings\General::SETTING_IMPRINT_ID)
                            ? __('Imprint page', RCB_TD)
                            : __('Hide on additional pages', RCB_TD),
                        $key
                    );
                    break;
                }
                return \true;
            case \DevOwl\RealCookieBanner\settings\General::SETTING_SET_COOKIES_VIA_MANAGER:
                if (!$this->isPro() && $value !== 'none') {
                    $onlyPro = \true;
                    break;
                }
                return \true;
            case \DevOwl\RealCookieBanner\settings\Multisite::SETTING_CONSENT_FORWARDING:
                if (!$this->isPro() && $value === \true) {
                    $onlyPro = \true;
                    break;
                }
                return \true;
            case \DevOwl\RealCookieBanner\settings\Multisite::SETTING_FORWARD_TO:
            case \DevOwl\RealCookieBanner\settings\Multisite::SETTING_CROSS_DOMAINS:
                if (!empty($value)) {
                    if ($this->isPro()) {
                        $this->addMessageOptionMultisite(
                            $optionName === \DevOwl\RealCookieBanner\settings\Multisite::SETTING_FORWARD_TO
                                ? __('Forward to', RCB_TD)
                                : __('External \'Forward To\' endpoints', RCB_TD),
                            $key
                        );
                    } else {
                        $onlyPro = \true;
                    }
                    break;
                }
                return \true;
            default:
                return \true;
        }
        $this->probablyAddMessageSettingOnlyPro($onlyPro, $key);
        return \false;
    }
}
