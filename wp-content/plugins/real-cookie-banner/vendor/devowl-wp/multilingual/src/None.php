<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual;

// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * No known plugin installed, fallback to this implementation.
 */
class None extends \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractLanguagePlugin {
    // Documented in AbstractLanguagePlugin
    public function switch($locale) {
        // Silence is golden.
    }
    // Documented in AbstractLanguagePlugin
    public function getActiveLanguages() {
        return [];
    }
    // Documented in AbstractLanguagePlugin
    public function getTranslatedName($locale) {
        return $locale;
    }
    // Documented in AbstractLanguagePlugin
    public function getWordPressCompatibleLanguageCode($locale) {
        return $locale;
    }
    // Documented in AbstractLanguagePlugin
    public function getDefaultLanguage() {
        return '';
    }
    // Documented in AbstractLanguagePlugin
    public function getCurrentLanguage() {
        return '';
    }
    // Documented in AbstractLanguagePlugin
    public function getOriginalPostId($id, $post_type) {
        return $id;
    }
    // Documented in AbstractLanguagePlugin
    public function getCurrentPostId($id, $post_type, $locale = null) {
        return $id;
    }
    // Documented in AbstractLanguagePlugin
    public function getCurrentTermId($id, $taxonomy, $locale = null) {
        return $id;
    }
}
