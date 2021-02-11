<?php

namespace DevOwl\RealCookieBanner\comp\language;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\TemporaryTextDomain;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\Localization;
use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\settings\Revision;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Language specific action and filters for Real Cookie Banner.
 */
class Hooks {
    const GET_QUERY_FORCE_LANG = RCB_OPT_PREFIX . 'ForceLang';
    const TD_FORCED = RCB_TD . '-forced';
    /**
     * Singleton instance.
     *
     * @var Hooks
     */
    private static $me = null;
    /**
     * Custom hints for multilingual.
     *
     * @param array $hints
     */
    public function hints($hints) {
        if ($this->compInstance()->isActive()) {
            $hints['deleteCookieGroup'][] = __(
                'If you delete a cookie group, it will not be deleted in other languages.',
                RCB_TD
            );
            $hints['deleteCookie'][] = __('If you delete a cookie, it will not be deleted in other languages.', RCB_TD);
            $hints['export'][] = __('The export contains only data from the current language.', RCB_TD);
        }
        return $hints;
    }
    /**
     * Query arguments `lang`.
     *
     * @param array $arguments
     */
    public function queryArguments($arguments) {
        if ($this->compInstance()->isActive()) {
            $arguments['lang'] = $this->compInstance()->getCurrentLanguage();
        }
        return $arguments;
    }
    /**
     * E. g. WPML is not correctly consuming the correct language in the WP REST API.
     * When a `forceLang` parameter is queried, let's switch to this language programmatically.
     */
    public function rest_api_init() {
        if (isset($_GET[self::GET_QUERY_FORCE_LANG])) {
            $this->compInstance()->switch($_GET[self::GET_QUERY_FORCE_LANG]);
        }
        $this->createTemporaryTextDomain();
    }
    /**
     * Modify query for REST queries.
     *
     * @param array $args Key value array of query var to query value.
     */
    public function rest_query($args) {
        return \DevOwl\RealCookieBanner\Core::getInstance()->queryArguments($args, 'restQuery');
    }
    /**
     * Create a temporary text domain of the current language.
     */
    public function createTemporaryTextDomain() {
        return \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\TemporaryTextDomain::fromPluginReceiver(
            self::TD_FORCED,
            RCB_TD,
            \DevOwl\RealCookieBanner\Core::getInstance(),
            $this->compInstance(),
            \DevOwl\RealCookieBanner\Localization::class
        );
    }
    /**
     * Add the current language code as independent context.
     *
     * @param array $contexts
     */
    public function context($contexts) {
        if ($this->compInstance()->isActive()) {
            $contexts['lang'] = $this->compInstance()->getCurrentLanguage();
        }
        return $contexts;
    }
    /**
     * Translate language context to human readable form.
     *
     * @param string $context
     */
    public function contextTranslate($context) {
        return $this->compInstance()->isActive()
            ? \preg_replace_callback(
                '/lang:([A-Za-z_]+)/m',
                function ($m) {
                    return __('Language', RCB_TD) . ': ' . $this->compInstance()->getTranslatedName($m[1]);
                },
                $context,
                1
            )
            : $context;
    }
    /**
     * A new revision was requested, let's recreate also for other languages.
     *
     * @param array $result
     */
    public function revisionHash($result) {
        if ($this->compInstance()->isActive()) {
            // Temporarily disable this filter
            remove_filter('RCB/Revision/Hash', [$this, 'revisionHash']);
            $currentLanguage = $result['revision']['lang'];
            $result['additionalLangHashRecreation'] = [];
            foreach ($this->compInstance()->getActiveLanguages() as $activeLanguage) {
                if ($activeLanguage !== $currentLanguage) {
                    // Switch to that language context and recreate hash
                    $this->compInstance()->switch($activeLanguage);
                    $langRevision = \DevOwl\RealCookieBanner\settings\Revision::getInstance()->create(\true);
                    $result['additionalLangHashRecreation'][$activeLanguage] = $langRevision;
                }
            }
            // Restore language back
            $this->compInstance()->switch($currentLanguage);
            // Enable filter again
            add_filter('RCB/Revision/Hash', [$this, 'revisionHash']);
        }
        return $result;
    }
    /**
     * Modify option value for imprint id so it gets correctly resolved to the current language post id.
     *
     * @param string $value
     */
    public function revisionOptionValue_pageId($value) {
        if ($this->compInstance()->isActive() && !empty($value) && \is_numeric($value)) {
            return $this->compInstance()->getCurrentPostId($value, 'page');
        }
        return $value;
    }
    /**
     * Modify content blocker `cookies` meta field to match the translated cookie ids.
     *
     * @param string $meta_value
     * @param int $from Object id of source language item
     * @param int $to Object id of destination language item
     * @param string $locale
     */
    public function copy_blocker_cookies_meta($meta_value, $from, $to, $locale) {
        if ($this->compInstance()->isActive() && !empty($meta_value)) {
            $ids = [];
            foreach (\explode(',', $meta_value) as $currentId) {
                $translationId = $this->compInstance()->getCurrentPostId(
                    $currentId,
                    \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME,
                    $locale
                );
                if ($translationId > 0 && \intval($translationId) !== \intval($currentId)) {
                    $ids[] = $translationId;
                }
            }
            return \join(',', $ids);
        }
        return $meta_value;
    }
    /**
     * Get compatibility language instance.
     */
    protected function compInstance() {
        return \DevOwl\RealCookieBanner\Core::getInstance()->getCompLanguage();
    }
    /**
     * Get singleton instance.
     *
     * @return Hooks
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\comp\language\Hooks()) : self::$me;
    }
}
