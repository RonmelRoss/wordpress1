<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual;

// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * There are plugins like TranslatePress, which does use a completely different way of
 * implementing multilingual content to WordPress sites.
 */
abstract class AbstractOutputBufferPlugin {
    /**
     * Get the HTML attribute so the "dynamic" replacement gets disabled
     * on frontend side. This can be useful for texts which are directly
     * translated in PHP already.
     *
     * @return string
     */
    abstract public function getSkipHTMLForTag();
    /**
     * Check if the translate plugin is currently in edit mode (preview).
     *
     * @return boolean
     */
    abstract public function isCurrentlyInEditorPreview();
    /**
     * Translate a string to a given locale.
     *
     * @param string $content
     * @param string $locale
     * @return string
     */
    abstract public function translateString($content, $locale = null);
    /**
     * Translate a complete array to a given locale (recursively).
     *
     * @param string $content
     * @param string $locale
     * @return string
     */
    public function translateArray($content, $locale = null) {
        return $this->array_map_recursive(function ($value) use ($locale) {
            if (\is_string($value)) {
                return $this->translateString($value, $locale);
            }
            return $value;
        }, $content);
    }
    /**
     * `array_map` recursively to translate the array.
     *
     * @param callback $callback
     * @param array $array
     * @see https://stackoverflow.com/a/39637749/5506547
     */
    protected function array_map_recursive($callback, $array) {
        $func = function ($item) use (&$func, &$callback) {
            return \is_array($item) ? \array_map($func, $item) : \call_user_func($callback, $item);
        };
        return \array_map($func, $array);
    }
    /**
     * Determine implementation class.
     *
     * @return AbstractOutputBufferPlugin
     */
    public static function determineImplementation() {
        if (\DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\TranslatePress::isPresent()) {
            return new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\TranslatePress();
        }
        return new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\NoOutputBuffer();
    }
}
