<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual;

// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * WPML language handler.
 */
class WPML extends \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractLanguagePlugin {
    // Documented in AbstractLanguagePlugin
    public function switch($locale) {
        global $sitepress;
        $sitepress->switch_lang($locale);
    }
    // Documented in AbstractLanguagePlugin
    public function copyTermToOtherLanguage($locale, $currentLanguage, $term_id, $taxonomy, $meta) {
        global $sitepress;
        $createdTermId = parent::copyTermToOtherLanguage($locale, $currentLanguage, $term_id, $taxonomy, $meta);
        if (!$createdTermId) {
            return \false;
        }
        // Create term translation (https://wordpress.stackexchange.com/a/309046/83335)
        $trid = $sitepress->get_element_trid($term_id, 'tax_' . $taxonomy);
        $sitepress->set_element_language_details($createdTermId, 'tax_' . $taxonomy, $trid, $locale, $currentLanguage);
        return $createdTermId;
    }
    // Documented in AbstractLanguagePlugin
    public function copyPostToOtherLanguage($locale, $currentLanguage, $post_id, $meta, $taxonomies) {
        global $sitepress;
        // Read post
        $post = get_post($post_id);
        // Create
        $created = parent::copyPostToOtherLanguage($locale, $currentLanguage, $post_id, $meta, $taxonomies);
        if (!$created) {
            return \false;
        }
        // WPML has an issue that the `trid` is not yet known directly in `save_post` (https://wpml.org/forums/topic/get_element_trid-returns-null/)
        // So, the posts are linked through the `shutdown` action.
        add_action('shutdown', function () use ($sitepress, $post, $post_id, $created, $locale, $currentLanguage) {
            $trid = $sitepress->get_element_trid($post_id, 'post_' . $post->post_type);
            $sitepress->set_element_language_details(
                $created,
                'post_' . $post->post_type,
                $trid,
                $locale,
                $currentLanguage
            );
        });
        return $created;
    }
    // Documented in AbstractLanguagePlugin
    public function getActiveLanguages() {
        return \array_keys(apply_filters('wpml_active_languages', []));
    }
    // Documented in AbstractLanguagePlugin
    public function getTranslatedName($locale) {
        $activeLanguages = apply_filters('wpml_active_languages', []);
        return isset($activeLanguages[$locale]) ? $activeLanguages[$locale]['translated_name'] : $locale;
    }
    // Documented in AbstractLanguagePlugin
    public function getWordPressCompatibleLanguageCode($locale) {
        return apply_filters('wpml_active_languages', [])[$locale]['default_locale'];
    }
    // Documented in AbstractLanguagePlugin
    public function getDefaultLanguage() {
        global $sitepress;
        return $sitepress->get_default_language();
    }
    // Documented in AbstractLanguagePlugin
    public function getCurrentLanguage() {
        global $sitepress;
        return $sitepress->get_current_language();
    }
    // Documented in AbstractLanguagePlugin
    public function getOriginalPostId($id, $post_type) {
        return \intval(icl_object_id($id, $post_type, \false, $this->getDefaultLanguage()));
    }
    // Documented in AbstractLanguagePlugin
    public function getCurrentPostId($id, $post_type, $locale = null) {
        return \intval(icl_object_id($id, $post_type, \true, $locale === null ? $this->getCurrentLanguage() : $locale));
    }
    // Documented in AbstractLanguagePlugin
    public function getCurrentTermId($id, $taxonomy, $locale = null) {
        return \intval(icl_object_id($id, $taxonomy, \true, $locale === null ? $this->getCurrentLanguage() : $locale));
    }
    /**
     * Check if WPML is active.
     */
    public static function isPresent() {
        global $sitepress;
        return $sitepress !== null && \get_class($sitepress) === 'SitePress';
    }
}
