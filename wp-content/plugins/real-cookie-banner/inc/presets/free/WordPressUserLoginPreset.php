<?php

namespace DevOwl\RealCookieBanner\presets\free;

use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\presets\AbstractCookiePreset;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * WordPress User Login cookie preset.
 */
class WordPressUserLoginPreset extends \DevOwl\RealCookieBanner\presets\AbstractCookiePreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_USER_LOGIN;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $cookieHost = \DevOwl\RealCookieBanner\Utils::host(\DevOwl\RealCookieBanner\Utils::HOST_TYPE_CURRENT);
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => __('User Login', RCB_TD),
            'logoFile' => admin_url('images/wordpress-logo.svg'),
            'attributes' => [
                'name' => __('WordPress User Login', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                'group' => __('Essential', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                'purpose' => __(
                    'WordPress is the content management system for this website and allows registered users to log in to the system. The cookies store the credentials of a logged-in user as hash, login status and user ID as well as user-related settings for the WordPress backend.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'provider' => get_bloginfo('name'),
                'providerPrivacyPolicy' => \DevOwl\RealCookieBanner\settings\General::getInstance()->getPrivacyPolicyUrl(
                    ''
                ),
                'technicalDefinitions' => [
                    [
                        'type' => 'http',
                        'name' => 'wordpress_*',
                        'host' => $cookieHost,
                        'duration' => 0,
                        'durationUnit' => 'y',
                        'sessionDuration' => \true
                    ],
                    [
                        'type' => 'http',
                        'name' => 'wordpress_logged_in_*',
                        'host' => $cookieHost,
                        'duration' => 0,
                        'durationUnit' => 'y',
                        'sessionDuration' => \true
                    ],
                    [
                        'type' => 'http',
                        'name' => 'wp-settings-*-*',
                        'host' => $cookieHost,
                        'duration' => 1,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'wordpress_test_cookie',
                        'host' => $cookieHost,
                        'duration' => 0,
                        'durationUnit' => 'y',
                        'sessionDuration' => \true
                    ]
                ],
                'codeOptOutDelete' => \false
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
