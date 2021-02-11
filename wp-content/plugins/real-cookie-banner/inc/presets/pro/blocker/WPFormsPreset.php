<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
use DevOwl\RealCookieBanner\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * WPFormsPreset with Google reCAPTCHA blocker preset.
 */
class WPFormsPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WPFORMS_RECAPTCHA;
    const SLUG_FREE = 'wpforms-lite';
    const SLUG_PRO = 'wpforms';
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => __('WPForms', RCB_TD),
            'description' => __('with Google reCAPTCHA', RCB_TD),
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/wpforms.png'),
            'disabled' => !self::isPluginActive()
        ];
    }
    // Self-explanatory
    public static function isPluginActive() {
        return \DevOwl\RealCookieBanner\Utils::anyPluginActive([self::SLUG_PRO, self::SLUG_FREE]);
    }
}
