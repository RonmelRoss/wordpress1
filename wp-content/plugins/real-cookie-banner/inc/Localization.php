<?php

namespace DevOwl\RealCookieBanner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\PolyLang;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\Sync;
use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Localization as UtilsLocalization;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\view\customize\banner\Legal;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * i18n management for backend and frontend.
 */
class Localization {
    use UtilsProvider;
    use UtilsLocalization;
    /**
     * Put your language overrides here!
     *
     * @param string $locale
     * @return string
     */
    public function override($locale) {
        switch ($locale) {
            // Put your overrides here!
            case 'de_AT':
            case 'de_CH':
            case 'de_CH_informal':
            case 'de_DE_formal':
                return 'de_DE';
                break;
            default:
                break;
        }
        return $locale;
    }
    /**
     * Get the directory where the languages folder exists.
     *
     * @param string $type
     * @return string[]
     */
    protected function getPackageInfo($type) {
        if ($type === \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Localization::$PACKAGE_INFO_BACKEND) {
            return [path_join(RCB_PATH, 'languages'), RCB_TD];
        } else {
            return [path_join(RCB_PATH, \DevOwl\RealCookieBanner\Assets::$PUBLIC_JSON_I18N), RCB_TD];
        }
    }
    /**
     * Make our plugin multilingual with the help of `AbstractLanguagePlugin` and `Sync`!
     * Also have a look at `BannerCustomize`, there are `LanguageDependingOption`'s.
     */
    public static function multilingual() {
        $compLanguage = \DevOwl\RealCookieBanner\Core::getInstance()->getCompLanguage();
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\Sync(
            [
                \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME =>
                    \DevOwl\RealCookieBanner\settings\Cookie::SYNC_OPTIONS,
                \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME =>
                    \DevOwl\RealCookieBanner\settings\Blocker::SYNC_OPTIONS
            ],
            [
                \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME =>
                    \DevOwl\RealCookieBanner\settings\CookieGroup::SYNC_OPTIONS
            ],
            $compLanguage
        );
        $idsToCurrent = [
            \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_PRIVACY_POLICY,
            \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_IMPRINT
        ];
        foreach ($idsToCurrent as $id) {
            add_filter('DevOwl/Customize/LocalizedValue/' . $id, function ($value) use ($compLanguage) {
                return $compLanguage->getCurrentPostId($value, \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME);
            });
        }
    }
}
