<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual;

use TRP_Translate_Press;
use TRP_Translation_Render;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * TranslatePress Output Buffering compatibility.
 *
 * @see https://translatepress.com/
 */
class TranslatePress extends \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractOutputBufferPlugin {
    const EDIT_QUERY_VAR = 'trp-edit-translation';
    // Documented in AbstractOutputBufferPlugin
    public function getSkipHTMLForTag() {
        return $this->isCurrentlyInEditorPreview() ? '' : 'data-no-dynamic-translation';
    }
    // Documented in AbstractOutputBufferPlugin
    public function isCurrentlyInEditorPreview() {
        return isset($_GET[self::EDIT_QUERY_VAR]) && $_GET[self::EDIT_QUERY_VAR] === 'preview';
    }
    // Documented in AbstractOutputBufferPlugin
    public function translateString($content, $locale = null) {
        if (\class_exists(\TRP_Translation_Render::class) && !$this->isCurrentlyInEditorPreview()) {
            $trp = \TRP_Translate_Press::get_trp_instance();
            /**
             * Renderer
             *
             * @var TRP_Translation_Render
             */
            $render = $trp->get_component('translation_render');
            if ($locale !== null) {
                global $TRP_LANGUAGE;
                $orig_lang = $TRP_LANGUAGE;
                $TRP_LANGUAGE = $locale;
            }
            $content = $render->translate_page($content);
            if ($locale !== null) {
                $TRP_LANGUAGE = $orig_lang;
            }
        }
        return $content;
    }
    /**
     * Check if TranslatePress is active. We also need to check for XML availability cause we need
     * to workaround this a bit (object to xml -> translate -> reverse).
     */
    public static function isPresent() {
        return \class_exists(\TRP_Translate_Press::class) && \class_exists('SimpleXMLElement');
    }
}
