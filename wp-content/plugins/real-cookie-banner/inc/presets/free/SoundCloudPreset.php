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
 * SoundCloud preset.
 */
class SoundCloudPreset extends \DevOwl\RealCookieBanner\presets\AbstractCookiePreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SOUNDCLOUD;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $name = 'SoundCloud';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/soundcloud.png'),
            'attributes' => [
                'name' => $name,
                'group' => __('Functional', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                'purpose' => __(
                    'SoundCloud allows embedding content posted on soundcloud.com directly into websites. The cookies are used to collect visited websites and detailed statistics about the user behaviour. This data can be linked to the data of users registered on soundcloud.com.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'technicalDefinitions' => [
                    [
                        'type' => 'local',
                        'name' => 'WIDGET::local::assignments',
                        'host' => 'w.soundcloud.com',
                        'durationUnit' => 'y',
                        'sessionDuration' => \false,
                        'duration' => 0
                    ],
                    [
                        'type' => 'local',
                        'name' => 'WIDGET::local::broadcast',
                        'host' => 'w.soundcloud.com',
                        'durationUnit' => 'y',
                        'sessionDuration' => \false,
                        'duration' => 0
                    ],
                    [
                        'type' => 'local',
                        'name' => 'WIDGET::local::auth',
                        'host' => 'w.soundcloud.com',
                        'durationUnit' => 'y',
                        'sessionDuration' => \false,
                        'duration' => 0
                    ],
                    [
                        'type' => 'http',
                        'name' => 'soundcloud_session_hint',
                        'host' => '.soundcloud.com',
                        'durationUnit' => 'y',
                        'sessionDuration' => \true,
                        'duration' => 0
                    ],
                    [
                        'type' => 'http',
                        'name' => 'authId',
                        'host' => '.soundcloud.com',
                        'durationUnit' => 'y',
                        'sessionDuration' => \true,
                        'duration' => 0
                    ],
                    [
                        'type' => 'http',
                        'name' => 'connect_session',
                        'host' => '.soundcloud.com',
                        'durationUnit' => 'y',
                        'sessionDuration' => \true,
                        'duration' => 0
                    ],
                    [
                        'type' => 'http',
                        'name' => '_gat_gtag_*',
                        'host' => '.soundcloud.com',
                        'duration' => 1,
                        'durationUnit' => 'h',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'rubicon_last_sync',
                        'host' => '.soundcloud.com',
                        'duration' => 1,
                        'durationUnit' => 'd',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => '_gid',
                        'host' => '.soundcloud.com',
                        'duration' => 1,
                        'durationUnit' => 'd',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'ja',
                        'host' => '.soundcloud.com',
                        'duration' => 1,
                        'durationUnit' => 'mo',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => '_fbp',
                        'host' => '.soundcloud.com',
                        'duration' => 3,
                        'durationUnit' => 'mo',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'sclocale',
                        'host' => '.soundcloud.com',
                        'duration' => 1,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'ab.storage.deviceId.*',
                        'host' => '.soundcloud.com',
                        'duration' => 1,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'ab.storage.userId.*',
                        'host' => '.soundcloud.com',
                        'duration' => 1,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'ab.storage.sessionId.*',
                        'host' => '.soundcloud.com',
                        'duration' => 1,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => '_ga',
                        'host' => '.soundcloud.com',
                        'duration' => 2,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'sc_anonymous_id',
                        'host' => '.soundcloud.com',
                        'duration' => 10,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'legacy_clean',
                        'host' => '.soundcloud.com',
                        'duration' => 10,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ]
                ],
                'provider' => 'SoundCloud Limited and SoundCloud Inc.',
                'providerPrivacyPolicy' => 'https://soundcloud.com/pages/privacy',
                'technicalHandlingNotice' => __(
                    'There is no need for an opt-in script because the SoundCloud content is usually loaded in an iframe. You must create a content blocker that will block SoundCloud until the user gives consent to load it.',
                    RCB_TD
                ),
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
