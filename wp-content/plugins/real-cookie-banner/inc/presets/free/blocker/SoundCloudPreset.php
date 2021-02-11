<?php

namespace DevOwl\RealCookieBanner\presets\free\blocker;

use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\free\SoundCloudPreset as FreeSoundCloudPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * SoundCloud blocker preset.
 */
class SoundCloudPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\free\SoundCloudPreset::IDENTIFIER;
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
                'description' => __(
                    'Audio from SoundCloud has been blocked because you did not allow to load it.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'hosts' => ['*w.soundcloud.com*'],
                'cookies' => [\DevOwl\RealCookieBanner\presets\free\SoundCloudPreset::IDENTIFIER]
            ]
        ];
    }
}
