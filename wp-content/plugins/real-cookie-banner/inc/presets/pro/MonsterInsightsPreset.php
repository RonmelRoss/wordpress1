<?php

namespace DevOwl\RealCookieBanner\presets\pro;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractCookiePreset;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
use DevOwl\RealCookieBanner\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * MonsterInsights preset -> Google Analytics cookie preset.
 */
class MonsterInsightsPreset extends \DevOwl\RealCookieBanner\presets\AbstractCookiePreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MONSTERINSIGHTS;
    const SLUG_PRO = 'google-analytics-premium';
    const SLUG_FREE = 'google-analytics-for-wordpress';
    const VERSION = \DevOwl\RealCookieBanner\presets\pro\GoogleAnalyticsPreset::VERSION;
    // Documented in AbstractPreset
    public function common() {
        $name = 'MonsterInsights';
        $extendsAttributes = (new \DevOwl\RealCookieBanner\presets\pro\GoogleAnalyticsPreset())->common();
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'description' => $extendsAttributes['description'],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/monster-insights.png'),
            'disabled' => !self::isPluginActive()
        ];
    }
    // Documented in AbstractPreset
    public function managerNone() {
        return \false;
    }
    // Documented in AbstractPreset
    public function managerGtm() {
        return \false;
    }
    // Documented in AbstractPreset
    public function managerMtm() {
        return \false;
    }
    // Self-explanatory
    public static function isPluginActive() {
        return \DevOwl\RealCookieBanner\Utils::anyPluginActive([self::SLUG_PRO, self::SLUG_FREE]);
    }
}
