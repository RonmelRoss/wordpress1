<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Customize;

// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Utility functionality for customize controls and output.
 */
class Utils {
    /**
     * Calculate rgba() from hex and alpha.
     *
     * @param string $hex
     * @param int $alpha
     */
    public static function calculateOverlay($hex, $alpha) {
        $rgb = self::hexToRgb($hex);
        return \sprintf('rgba(%d, %d, %d, %f)', $rgb['r'], $rgb['g'], $rgb['b'], $alpha / 100);
    }
    /**
     * Calculate RGB from hex string.
     *
     * @param string $hex
     */
    public static function hexToRgb($hex) {
        if (
            \preg_match('/^#?([a-f\\d]{2})([a-f\\d]{2})([a-f\\d]{2})$/i', $hex, $matches, \PREG_OFFSET_CAPTURE, 0) === 1
        ) {
            return [
                'r' => \intval($matches[1][0], 16),
                'g' => \intval($matches[2][0], 16),
                'b' => \intval($matches[3][0], 16)
            ];
        }
        return null;
    }
}
