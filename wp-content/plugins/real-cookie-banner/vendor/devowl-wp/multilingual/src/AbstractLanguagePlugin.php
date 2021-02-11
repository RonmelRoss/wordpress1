<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual;

use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Localization;
use WP_Post;
use WP_Term;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * There are plugins like WPML or PolyLang which allows you to create a multilingual
 * WordPress installation. devowl.io plugins needs to be compatible with those plugins
 * so this abstract implementation handles actions like get original ID and get default language.
 */
abstract class AbstractLanguagePlugin {
    const TEMPORARY_TEXT_DOMAIN_PREFIX = 'multilingual-temporary-text-domain';
    /**
     * Use this as text domain for translations. E. g. `post_title` is automatically
     * passed while duplicating a post to another language.
     *
     * @var string
     */
    private $domain;
    private $moFile;
    private $overrideClass;
    /**
     * Temporary text domain, if given.
     *
     * @var TemporaryTextDomain
     */
    private $temporaryTextDomain;
    /**
     * Current translations hold as an instance.
     */
    private $currentTranslationEntries;
    /**
     * C'tor.
     *
     * @param string $domain Original text domain where `post_title` and so on are translated
     * @param string $moFile Needed for `TemporaryTextDomain`. E. g. `/var/www/html/wp-content/plugins/real-cookie-banner/languages/real-cookie-banner-%s.mo`
     * @param mixed $overrideClass A class with a `override` method (arguments: `locale`)
     * @codeCoverageIgnore
     */
    public function __construct($domain, $moFile = null, $overrideClass = null) {
        $this->domain = $domain;
        $this->moFile = $moFile;
        $this->overrideClass = $overrideClass;
    }
    /**
     * Switch to a given language code.
     *
     * @param string $locale
     */
    abstract public function switch($locale);
    /**
     * Get all active languages.
     *
     * @return string[]
     */
    abstract public function getActiveLanguages();
    /**
     * Get translated name for a given locale.
     *
     * @param string $locale
     * @return string
     */
    abstract public function getTranslatedName($locale);
    /**
     * Get the WordPress compatible language code of a given locale.
     *
     * @param string $locale
     * @return string
     */
    abstract public function getWordPressCompatibleLanguageCode($locale);
    /**
     * Get default language.
     *
     * @return string
     */
    abstract public function getDefaultLanguage();
    /**
     * Get current language.
     *
     * @return string
     */
    abstract public function getCurrentLanguage();
    /**
     * Get original id of passed post id.
     *
     * @param int $id
     * @param string $post_type
     * @return int
     */
    abstract public function getOriginalPostId($id, $post_type);
    /**
     * Get current id of passed post id and fallback to passed id,
     * when no translation found.
     *
     * @param int $id
     * @param string $post_type
     * @param string $locale Get item of this language
     * @return int
     */
    abstract public function getCurrentPostId($id, $post_type, $locale = null);
    /**
     * Get current id of passed term id and fallback to `0` when not translation found.
     *
     * @param int $id
     * @param string $taxonomy
     * @param string $locale Get item of this language
     * @return int
     */
    abstract public function getCurrentTermId($id, $taxonomy, $locale = null);
    /**
     * This method is called due to `Sync::created_term`. It allows you to get a list of all
     * translations of a term in an associate array.
     *
     * @param int[] $translations
     */
    public function termCopiedToAllOtherLanguages($translations) {
        // Silence is golden.
    }
    /**
     * This method is called due to `Sync::save_post`. It allows you to get a list of all
     * translations of a post in an associate array.
     *
     * @param int[] $translations
     */
    public function postCopiedToAllOtherLanguages($translations) {
        // Silence is golden.
    }
    /**
     * This method is called due to `Sync::created_term`. It allows you to assign a term to a given language.
     *
     * @param int $termId
     * @param string $locale
     */
    public function setTermLanguage($termId, $locale) {
        // Silence is golden.
    }
    /**
     * This method is called due to `Sync::save_post`. It allows you to assign a post to a given language.
     *
     * @param int $postId
     * @param string $locale
     */
    public function setPostLanguage($postId, $locale) {
        // Silence is golden.
    }
    /**
     * Get current language or fallback to default language when the multilingual is in a state
     * like "Show all languages" (option known in the admin toolbar).
     */
    public function getCurrentLanguageFallback() {
        $current = $this->getCurrentLanguage();
        return empty($current) ? $this->getDefaultLanguage() : $current;
    }
    /**
     * Translate given term to other language.
     *
     * @param string $locale
     * @param string $currentLanguage
     * @param int $term_id
     * @param string $taxonomy
     * @param string[] $meta The meta keys to copy
     * @return int|boolean The new created term id
     */
    public function copyTermToOtherLanguage($locale, $currentLanguage, $term_id, $taxonomy, $meta) {
        // Read term
        $term = get_term($term_id);
        // Create
        $createdTermId = $this->duplicateTerm($term, $taxonomy);
        if (is_wp_error($createdTermId)) {
            return \false;
        }
        $this->duplicateTermMeta($term_id, $createdTermId, $meta);
        return $createdTermId;
    }
    /**
     * Translate given post to other language.
     *
     * @param string $locale
     * @param string $currentLanguage
     * @param string $post_id
     * @param string[] $meta The meta keys to copy
     * @param string[] $taxonomies The taxonomies to copy
     * @return int|boolean The new created post id
     */
    public function copyPostToOtherLanguage($locale, $currentLanguage, $post_id, $meta, $taxonomies) {
        // Read post
        $post = get_post($post_id);
        // Create
        $created = $this->duplicatePost($post);
        if ($created === 0) {
            return \false;
        }
        $this->copyPostTaxonomies($post_id, $created, $taxonomies, $locale);
        $this->duplicatePostMeta($post_id, $created, $meta);
        return $created;
    }
    /**
     * Iterate all other languages than current one and get their context.
     * Context = switch to the language.
     *
     * @param callback $callback Arguments: $locale, $currentLanguage
     */
    public function iterateOtherLanguagesContext($callback) {
        $currentLanguage = $this->getCurrentLanguageFallback();
        $languages = $this->getActiveLanguages();
        // Keep current language for translation purposes
        $this->currentTranslationEntries = $this->getTranslations();
        foreach ($languages as $locale) {
            if ($locale === $currentLanguage) {
                continue;
            }
            $this->switchToLanguage($locale, $callback);
        }
        unset($this->currentTranslationEntries);
    }
    /**
     * Get translations for the given domain. It also searches for temporary text domains
     * if we are e. g. in the default POT file language (in most cases English).
     */
    protected function getTranslations() {
        $entries = get_translations_for_domain($this->domain)->entries;
        if (\count($entries) > 0) {
            return $entries;
        }
        $temporary = \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\TemporaryTextDomain::fromFallbackDomain(
            $this->domain
        );
        if ($temporary !== null) {
            return $temporary->getEntries();
        }
        return [];
    }
    /**
     * Open given language and get their context. Context = switch to the language.
     *
     * @param string $locale
     * @param callback $callback Arguments: $locale, $currentLanguage
     */
    public function switchToLanguage($locale, $callback) {
        // Switch to other language
        $currentLanguage = $this->getCurrentLanguageFallback();
        $this->createTemporaryTextDomain($locale);
        $this->switch($locale);
        $result = \call_user_func($callback, $locale, $currentLanguage);
        // Restore to previous
        $this->teardownTemporaryTextDomain();
        $this->switch($currentLanguage);
        return $result;
    }
    /**
     * Create a temporary text domain.
     *
     * @param string $locale
     */
    public function createTemporaryTextDomain($locale) {
        if ($this->moFile !== null) {
            $skipFallbackTranslation = \false;
            $useLocale = $this->getWordPressCompatibleLanguageCode($locale);
            if ($this->overrideClass !== null) {
                $overrideClass = $this->overrideClass;
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
            $this->temporaryTextDomain = new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\TemporaryTextDomain(
                self::TEMPORARY_TEXT_DOMAIN_PREFIX . '-' . $this->domain,
                $this->domain,
                \sprintf($this->moFile, $useLocale),
                $skipFallbackTranslation
            );
        }
    }
    /**
     * Teardown the known temporary text domain.
     */
    public function teardownTemporaryTextDomain() {
        if ($this->temporaryTextDomain !== null) {
            $this->temporaryTextDomain->teardown();
            $this->temporaryTextDomain = null;
        }
    }
    /**
     * A simple `get_term` => `wp_insert_term` wrapper.
     *
     * @param WP_Term $term
     * @param string $taxonomy
     */
    protected function duplicateTerm($term, $taxonomy) {
        // Translate name and description
        $name = $this->translateInput($term->name);
        $description = $this->translateInput($term->description);
        // Create
        $created = wp_insert_term($name, $taxonomy, [
            'slug' => $name . '-' . $this->getCurrentLanguageFallback(),
            // E. g. PolyLang reports "Term already exists"
            'description' => $description
        ]);
        return is_wp_error($created) ? $created : $created['term_id'];
    }
    /**
     * A simple `get_post` => `wp_insert_post` wrapper.
     *
     * @param WP_Post $post
     */
    protected function duplicatePost($post) {
        // Translate name and description
        $args = [
            'post_title' => $this->translateInput($post->post_title),
            'post_content' => $this->translateInput($post->post_content),
            'post_status' => $post->post_status,
            'post_type' => $post->post_type,
            'menu_order' => $post->menu_order
        ];
        // Create
        return wp_insert_post($args);
    }
    /**
     * Listen to term meta addition and copy.
     *
     * @param int $from
     * @param int $to
     * @param string[] $meta Meta keys to copy
     */
    protected function duplicateTermMeta($from, $to, $meta) {
        $this->duplicateMeta('term', $from, $to, $meta);
    }
    /**
     * Copy already existing meta as it can be inserted with `meta_input` directly.
     * Additionally listen to term meta addition and copy.
     *
     * @param int $from
     * @param int $to
     * @param string[] $meta Meta keys to copy
     */
    public function duplicatePostMeta($from, $to, $meta) {
        $customMeta = get_post_custom($from);
        foreach ($customMeta as $key => $values) {
            if (\in_array($key, $meta, \true)) {
                foreach ($values as $value) {
                    add_post_meta(
                        $to,
                        $key,
                        $this->filterMetaValue('post', $from, $to, $key, $value, $this->getCurrentLanguageFallback())
                    );
                }
            }
        }
        $this->duplicateMeta('post', $from, $to, $meta);
    }
    /**
     * Listen to meta (term, post, ...) addition and copy.
     *
     * @param string $type E. g. 'post'
     * @param int $from
     * @param int $to
     * @param string[] $meta Meta keys to copy
     */
    protected function duplicateMeta($type, $from, $to, $meta) {
        $locale = $this->getCurrentLanguageFallback();
        add_action(
            'added_' . $type . '_meta',
            function ($mid, $object_id, $meta_key, $_meta_value) use ($from, $to, $meta, $type, $locale) {
                if ($object_id === $from && \in_array($meta_key, $meta, \true)) {
                    \call_user_func(
                        'add_' . $type . '_meta',
                        $to,
                        $meta_key,
                        $this->filterMetaValue($type, $from, $to, $meta_key, $_meta_value, $locale)
                    );
                }
            },
            10,
            4
        );
    }
    /**
     * Copy already existing taxonomies as it can be inserted with `tax_input` directly.
     * Additionally listen to term additions and copy.
     *
     * @param int $from
     * @param int $to
     * @param string[] $taxonomies Taxonomy keys to copy
     * @param string $locale The destination locale
     */
    public function copyPostTaxonomies($from, $to, $taxonomies, $locale) {
        foreach ($taxonomies as $taxonomy) {
            $originalTerms = get_the_terms($from, $taxonomy);
            if (\is_array($originalTerms)) {
                $copyIds = [];
                foreach ($originalTerms as $term) {
                    // Get category id of the original term id for the other language
                    $newTermId = $this->getCurrentTermId($term->term_id, $taxonomy, $locale);
                    if ($newTermId > 0) {
                        $copyIds[] = \intval($newTermId);
                    }
                }
                wp_set_object_terms($to, $copyIds, $taxonomy);
            }
        }
        add_action(
            'set_object_terms',
            function ($object_id, $terms, $tt_ids, $taxonomy, $append) use ($from, $to, $taxonomies, $locale) {
                if ($object_id === $from && \in_array($taxonomy, $taxonomies, \true) && $from !== $to) {
                    $copyIds = [];
                    foreach ($terms as $term) {
                        // Get category id of the original term id for the other language
                        $newTermId = $this->getCurrentTermId(get_term($term)->term_id, $taxonomy, $locale);
                        if ($newTermId > 0) {
                            $copyIds[] = \intval($newTermId);
                        }
                    }
                    wp_set_object_terms($to, $copyIds, $taxonomy, $append);
                }
            },
            10,
            5
        );
    }
    /**
     * Apply a WordPress filter so a meta value can be modified for copy process
     * to other languages.
     *
     * @param string $type E. g. 'post'
     * @param int $from Object id of source language item
     * @param int $to Object id of destination language item
     * @param string $meta_key
     * @param mixed $meta_value
     * @param string $locale Destination locale
     */
    public function filterMetaValue($type, $from, $to, $meta_key, $meta_value, $locale) {
        /**
         * Allows to modify a meta value when it gets copied to another language.
         *
         * @hook DevOwl/Multilingual/Copy/Meta/$type/$meta_key
         * @param {mixed} $meta_value
         * @param {int} $from Object id of source language item
         * @param {int} $to Object id of destination language item
         * @param string $locale Destination locale
         * @return {mixed}
         */
        return apply_filters(
            'DevOwl/Multilingual/Copy/Meta/' . $type . '/' . $meta_key,
            $meta_value,
            $from,
            $to,
            $locale
        );
    }
    /**
     * Translate a given input from known translations (.po, .pot).
     *
     * @param string $input
     */
    public function translateInput($input) {
        return \call_user_func(
            '__',
            $this->findI18nKeyOfTranslation($input),
            self::TEMPORARY_TEXT_DOMAIN_PREFIX . '-' . $this->domain
        );
    }
    /**
     * Find an i18n key for `__()` from a given translated string.
     *
     * @param string $input
     */
    public function findI18nKeyOfTranslation($input) {
        if ($this->currentTranslationEntries !== null) {
            // Find source key of translation
            foreach ($this->currentTranslationEntries as $translation) {
                $index = \array_search($input, $translation->translations, \true);
                if ($index !== \false) {
                    switch ($index) {
                        case 0:
                            return $translation->singular;
                        case 1:
                            return $translation->plural;
                        default:
                            return $input;
                    }
                }
            }
        }
        return $input;
    }
    /**
     * Is a multilingual plugin active?
     */
    public function isActive() {
        return !empty($this->getCurrentLanguage());
    }
    /**
     * Determine implementation class.
     *
     * @param string $domain
     * @param string $moFile Needed for `TemporaryTextDomain`. E. g. `/var/www/html/wp-content/plugins/real-cookie-banner/languages/real-cookie-banner-%s.mo`
     * @param mixed $overrideClass A class with a `override` method (arguments: `locale`)
     * @return AbstractLanguagePlugin
     */
    public static function determineImplementation($domain = '', $moFile = null, $overrideClass = null) {
        if (\DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\WPML::isPresent()) {
            return new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\WPML($domain, $moFile, $overrideClass);
        } elseif (\DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\PolyLang::isPresent()) {
            return new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\PolyLang($domain, $moFile, $overrideClass);
        }
        return new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\None($domain, $moFile, $overrideClass);
    }
}
