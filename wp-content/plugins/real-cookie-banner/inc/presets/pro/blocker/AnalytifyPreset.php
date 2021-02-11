<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\pro\AnalytifyPreset as PresetsAnalytifyPreset;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Analytify preset -> Google Analytics blocker preset.
 */
class AnalytifyPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\AnalytifyPreset::IDENTIFIER;
    const VERSION = \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAnalyticsPreset::VERSION;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Analytify';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/analytify.png'),
            'disabled' => !\DevOwl\RealCookieBanner\presets\pro\AnalytifyPreset::isPluginActive()
        ];
    }
}
