<?php

namespace DevOwl\RealCookieBanner\presets;

use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\free\blocker\FontAwesomePreset;
use DevOwl\RealCookieBanner\presets\free\blocker\GravatarPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\GoogleFontsPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\YoutubePreset;
use DevOwl\RealCookieBanner\presets\free\blocker\VimeoPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\JetPackSiteStatsPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\JetPackCommentsPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\SoundCloudPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\WordPressEmojisPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Predefined presets for blocker.
 */
class BlockerPresets extends \DevOwl\RealCookieBanner\presets\Presets {
    const CLASSES = [
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_FONTS =>
            \DevOwl\RealCookieBanner\presets\free\blocker\GoogleFontsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::YOUTUBE =>
            \DevOwl\RealCookieBanner\presets\free\blocker\YoutubePreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::VIMEO =>
            \DevOwl\RealCookieBanner\presets\free\blocker\VimeoPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::JETPACK_SITE_STATS =>
            \DevOwl\RealCookieBanner\presets\free\blocker\JetPackSiteStatsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::JETPACK_COMMENTS =>
            \DevOwl\RealCookieBanner\presets\free\blocker\JetPackCommentsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GRAVATAR =>
            \DevOwl\RealCookieBanner\presets\free\blocker\GravatarPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SOUNDCLOUD =>
            \DevOwl\RealCookieBanner\presets\free\blocker\SoundCloudPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_EMOJIS =>
            \DevOwl\RealCookieBanner\presets\free\blocker\WordPressEmojisPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FONTAWESOME =>
            \DevOwl\RealCookieBanner\presets\free\blocker\FontAwesomePreset::class
    ];
    const PRESETS_TYPE = 'blocker';
    /**
     * C'tor.
     */
    public function __construct() {
        parent::__construct(self::PRESETS_TYPE);
    }
    // Documented in Presets
    public function getClassList($force = \false) {
        /**
         * Filters available presets for blocker.
         *
         * @hook RCB/Presets/Blocker
         * @param {string} $presets All available presets. `[id => <extends AbstractBlockerPreset>::class]`
         * @returns {string}
         */
        $list = apply_filters('RCB/Presets/Blocker', self::CLASSES);
        if ($this->needsRecalculation() || $force) {
            $this->persist($this->fromClassList($list));
        }
        return $list;
    }
    /**
     * Resolve `attributes.cookies` so we can e.g. show created cookies in "Connected cookies"
     * in blocker edit form.
     *
     * @param array $preset Result of `getWithAttributes()`
     */
    public function resolveAvailableCookies(&$preset) {
        $cookiePresets = new \DevOwl\RealCookieBanner\presets\CookiePresets();
        $existingCookies = \DevOwl\RealCookieBanner\presets\CookiePresets::getCookiesWithPreset();
        if ($preset !== \false) {
            $newCookies = [];
            foreach ($preset['attributes']['cookies'] as $cookie) {
                if (\is_string($cookie)) {
                    // It should reference to an existing preset, let's resolve the ID
                    foreach ($existingCookies as $existingCookie) {
                        if (
                            $existingCookie->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID] ===
                            $cookie
                        ) {
                            $newCookies[] = $existingCookie->ID;
                            continue 2;
                        }
                    }
                    // Cookie preset is available, but does not actually exist as cookie
                    $cookieAttributes = $cookiePresets->getFromCache($cookie);
                    $cookieName = $cookieAttributes['name'];
                    $cookieDescription = $cookieAttributes['description'] ?? '';
                    $newCookies[] = [
                        'id' => $cookie,
                        'name' =>
                            $cookieName . (empty($cookieDescription) ? '' : \sprintf(' (%s)', $cookieDescription)),
                        'version' => $cookieAttributes['version'],
                        'attributes' => $cookiePresets->getWithAttributes($cookie)['attributes']
                    ];
                } else {
                    $newCookies[] = $cookie;
                }
            }
            $preset['attributes']['cookies'] = $newCookies;
        }
        return $preset;
    }
    // Documented in Presets
    public function fromClassList($clazzes) {
        $existingBlocker = self::getBlockerWithPreset();
        foreach ($clazzes as $id => $clazz) {
            /**
             * Instance.
             *
             * @var AbstractBlockerPreset
             */
            $instance = new $clazz();
            $preset = $instance->common();
            if (!isset($preset['tags'])) {
                $preset['tags'] = [];
            }
            /**
             * Inject some middleware directly to the content blocker preset. This can be useful to
             * enhance the preset with functionalities like `extends`.
             *
             * @hook RCB/Presets/Blocker/Middleware
             * @param {array} $preset The preset passed as reference
             * @param {AbstractCookiePreset} $instance Preset instance
             * @param {WP_Post[]} $existingBlocker
             * @returns {array}
             */
            $preset = apply_filters_ref_array('RCB/Presets/Blocker/Middleware', [
                &$preset,
                $instance,
                $existingBlocker
            ]);
            $result[$id] = $preset;
        }
        return $result;
    }
    /**
     * Get all available blocker with a preset.
     */
    public static function getBlockerWithPreset() {
        return \DevOwl\RealCookieBanner\settings\Blocker::getInstance()->getOrdered(
            \false,
            get_posts(
                \DevOwl\RealCookieBanner\Core::getInstance()->queryArguments(
                    [
                        'post_type' => \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME,
                        'numberposts' => -1,
                        'nopaging' => \true,
                        'meta_query' => [
                            [
                                'key' => \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID,
                                'compare' => 'EXISTS'
                            ]
                        ],
                        'post_status' => ['publish', 'private', 'draft']
                    ],
                    'blockerWithPreset'
                )
            )
        );
    }
}
