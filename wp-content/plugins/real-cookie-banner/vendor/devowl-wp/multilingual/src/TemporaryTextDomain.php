<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual;

use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\PluginReceiver;
use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Localization;
use MO;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Allows to set a given text domain to be translated from a .mo file.
 */
class TemporaryTextDomain {
    /**
     * A collection of all instances with the fallback text domain as key.
     * This is needed to get translations in `AbstractLanguagePlugin` also for
     * default-POT file (in most cases English)
     *
     * @var TemporaryTextDomain[]
     */
    private static $instances = [];
    private $domain;
    private $fallbackDomain;
    private $mofile;
    /**
     * MO instance. Can be null if the given mo file is not found.
     *
     * @var MO
     */
    private $mo;
    private $skipFallbackTranslation;
    /**
     * C'tor.
     *
     * @param string $domain
     * @param string $fallbackDomain
     * @param string $mofile
     * @param boolean $skipFallbackTranslation
     * @codeCoverageIgnore
     */
    public function __construct($domain, $fallbackDomain, $mofile, $skipFallbackTranslation = \false) {
        $this->domain = $domain;
        $this->fallbackDomain = $fallbackDomain;
        $this->mofile = $mofile;
        $this->skipFallbackTranslation = $skipFallbackTranslation;
        $this->createMo();
        $this->hooks();
    }
    /**
     * Create a MO instance.
     *
     * @see https://stackoverflow.com/a/28604283/5506547
     */
    protected function createMo() {
        if (!\file_exists($this->mofile)) {
            return;
        }
        $this->mo = new \MO();
        $this->mo->import_from_file($this->mofile);
        self::$instances[$this->fallbackDomain] = $this;
    }
    /**
     * Create `gettext` hooks.
     */
    protected function hooks() {
        add_filter('gettext', [$this, 'gettext'], 1, 3);
    }
    /**
     * Teardown the `gettext` filter.
     */
    public function teardown() {
        remove_filter('gettext', [$this, 'gettext'], 1, 3);
        unset($this->mo);
    }
    /**
     * Gettext filter.
     *
     * @param string $translation Translated text.
     * @param string $text Text to translate.
     * @param string $domain Text domain. Unique identifier for retrieving translated strings.
     */
    public function gettext($translation, $text, $domain) {
        if ($this->domain === $domain) {
            if ($this->mo === null) {
                if ($this->skipFallbackTranslation) {
                    return $text;
                }
                return \call_user_func('translate', $text, $this->fallbackDomain);
            }
            return $this->mo->translate($text);
        }
        return $translation;
    }
    /**
     * Get all translation entries of the given MO file.
     */
    public function getEntries() {
        return isset($this->mo) ? $this->mo->entries : [];
    }
    /**
     * Create a temporary text domain from a given WP React Starter plugin receiver.
     *
     * @param string $domain
     * @param string $fallbackDomain
     * @param PluginReceiver $receiver
     * @param AbstractLanguagePlugin $compLanguage
     * @param string $overrideClass A class with a `override` method (arguments: `locale`)
     */
    public static function fromPluginReceiver(
        $domain,
        $fallbackDomain,
        $receiver,
        $compLanguage,
        $overrideClass = null
    ) {
        $skipFallbackTranslation = \false;
        // Never use the language of the compatible plugin while deactivation
        if (isset($_GET['action'], $_GET['plugin']) && $_GET['action'] === 'deactivate') {
            $useLocale = '';
        } else {
            $useLocale = $compLanguage->getWordPressCompatibleLanguageCode($compLanguage->getCurrentLanguageFallback());
        }
        // Fallback to blog language
        if (empty($useLocale)) {
            $useLocale = \str_replace('-', '_', get_bloginfo('language'));
        }
        if ($overrideClass !== null) {
            /**
             * Localization instance.
             *
             * @var Localization
             */
            $overrideClassInstance = new $overrideClass();
            $useLocale = $overrideClassInstance->override($useLocale);
            // Check if fallback should be skipped if the POT language is currently in use
            $skipFallbackTranslation = \in_array($useLocale, $overrideClassInstance->getPotLanguages(), \true);
        }
        $path =
            untrailingslashit(
                plugin_dir_path(
                    $receiver->getPluginConstant(
                        \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\PluginReceiver::$PLUGIN_CONST_FILE
                    )
                )
            ) . $receiver->getPluginData('DomainPath');
        $mo =
            trailingslashit($path) .
            $receiver->getPluginConstant(
                \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\PluginReceiver::$PLUGIN_CONST_TEXT_DOMAIN
            ) .
            '-' .
            $useLocale .
            '.mo';
        return new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\TemporaryTextDomain(
            $domain,
            $fallbackDomain,
            $mo,
            $skipFallbackTranslation
        );
    }
    /**
     * Get an instance from a given fallback domain.
     *
     * @param string $fallbackDomain
     */
    public static function fromFallbackDomain($fallbackDomain) {
        return isset(self::$instances[$fallbackDomain]) ? self::$instances[$fallbackDomain] : null;
    }
}
