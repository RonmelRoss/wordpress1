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
 * Contact Form 7 with Google reCAPTCHA blocker preset.
 */
class ContactForm7RecaptchaPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CONTACT_FORM_7_RECAPTCHA;
    const SLUG = 'contact-form-7';
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => __('Contact Form 7', RCB_TD),
            'description' => __('with Google reCAPTCHA', RCB_TD),
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/contact-form-7.png'),
            'disabled' => !self::isPluginActive()
        ];
    }
    // Self-explanatory
    public static function isPluginActive() {
        return \DevOwl\RealCookieBanner\Utils::isPluginActive(self::SLUG);
    }
}
