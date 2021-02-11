<?php

namespace DevOwl\RealCookieBanner\presets\free\blocker;

use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\free\VimeoPreset as FreeVimeoPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Vimeo blocker preset.
 */
class VimeoPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\free\VimeoPreset::IDENTIFIER;
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
                'description' => __(
                    'Video from Vimeo has been blocked because you did not allow to load it.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'hosts' => ['*player.vimeo.com*', '*vimeocdn.com*'],
                'cookies' => [\DevOwl\RealCookieBanner\presets\free\VimeoPreset::IDENTIFIER]
            ]
        ];
    }
}
