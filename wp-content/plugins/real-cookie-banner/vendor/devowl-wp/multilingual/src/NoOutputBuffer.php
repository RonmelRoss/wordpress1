<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual;

// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * No known plugin installed, fallback to this implementation.
 */
class NoOutputBuffer extends \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractOutputBufferPlugin {
    // Documented in AbstractOutputBufferPlugin
    public function getSkipHTMLForTag() {
        return '';
    }
    // Documented in AbstractOutputBufferPlugin
    public function isCurrentlyInEditorPreview() {
        return \false;
    }
    // Documented in AbstractOutputBufferPlugin
    public function translateString($content, $locale = null) {
        return $content;
    }
}
