<?php

namespace DevOwl\RealCookieBanner\presets\free;

use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractCookiePreset;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Vimeo cookie preset.
 */
class VimeoPreset extends \DevOwl\RealCookieBanner\presets\AbstractCookiePreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::VIMEO;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Vimeo';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/vimeo.png'),
            'attributes' => [
                'name' => $name,
                'group' => __('Functional', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                'purpose' => __(
                    'Vimeo allows embedding content posted on vimeo.com directly into websites. The cookies are used to collect visited websites and detailed statistics about the user behaviour. This data can be linked to the data of users registered on vimeo.com.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'provider' => 'Vimeo Inc.',
                'providerPrivacyPolicy' => 'https://vimeo.com/privacy',
                'technicalDefinitions' => [
                    [
                        'type' => 'http',
                        'name' => 'vuid',
                        'host' => '.vimeo.com',
                        'durationUnit' => 'y',
                        'sessionDuration' => \false,
                        'duration' => 10
                    ],
                    [
                        'type' => 'http',
                        'name' => 'player',
                        'host' => '.vimeo.com',
                        'duration' => 1,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'local',
                        'name' => 'sync_volume',
                        'host' => 'player.vimeo.com',
                        'durationUnit' => 'y',
                        'sessionDuration' => \false,
                        'duration' => 0
                    ],
                    [
                        'type' => 'local',
                        'name' => 'sync_active',
                        'host' => 'player.vimeo.com',
                        'durationUnit' => 'y',
                        'sessionDuration' => \false,
                        'duration' => 0
                    ],
                    [
                        'type' => 'http',
                        'name' => 'vimeo',
                        'host' => '.vimeo.com',
                        'duration' => 1,
                        'durationUnit' => 'mo',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'has_logged_in',
                        'host' => '.vimeo.com',
                        'duration' => 6,
                        'durationUnit' => 'mo',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'is_logged_in',
                        'host' => '.vimeo.com',
                        'duration' => 10,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => '_uetvid',
                        'host' => '.vimeo.com',
                        'duration' => 21,
                        'durationUnit' => 'd',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'has_logged_in',
                        'host' => '.vimeo.com',
                        'duration' => 10,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => '_fbp',
                        'host' => '.vimeo.com',
                        'duration' => 3,
                        'durationUnit' => 'mo',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => '_uetsid',
                        'host' => '.vimeo.com',
                        'duration' => 1,
                        'durationUnit' => 'd',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => '_gat_UA-*',
                        'host' => '.vimeo.com',
                        'duration' => 1,
                        'durationUnit' => 'h',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => '_gid',
                        'host' => '.vimeo.com',
                        'duration' => 1,
                        'durationUnit' => 'd',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'continuous_play_v3',
                        'host' => '.vimeo.com',
                        'duration' => 1,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => '_gcl_au',
                        'host' => '.vimeo.com',
                        'duration' => 3,
                        'durationUnit' => 'mo',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => '_ga',
                        'host' => '.vimeo.com',
                        'duration' => 2,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ]
                ],
                'technicalHandlingNotice' => __(
                    'There is no need for an opt-in script because the Vimeo content is usually loaded in an iframe. You must create a content blocker that will block Vimeo until the user gives consent to load it.',
                    RCB_TD
                ),
                'codeOptOutDelete' => \false,
                'ePrivacyUSA' => \true
            ]
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
}
