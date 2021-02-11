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
 * Ninja Forms with Google reCAPTCHA blocker preset.
 */
class NinjaFormsPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::NINJA_FORMS_RECAPTCHA;
    const SLUG = 'ninja-forms';
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => __('Ninja Forms', RCB_TD),
            'description' => __('with Google reCAPTCHA', RCB_TD),
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/ninja-forms.png'),
            'disabled' => !self::isPluginActive()
        ];
    }
    // Self-explanatory
    public static function isPluginActive() {
        return \DevOwl\RealCookieBanner\Utils::isPluginActive(self::SLUG);
    }
}
