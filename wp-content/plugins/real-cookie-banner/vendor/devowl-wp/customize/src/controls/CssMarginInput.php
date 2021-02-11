<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls;

use WP_Customize_Control;
use WP_Customize_Manager;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Provide a CSS margin input with 4 dimension input fields (top, right, bottom, left).
 * It can also be used for padding.
 */
class CssMarginInput extends \WP_Customize_Control {
    /**
     * Type.
     *
     * @var string
     */
    public $type = 'cssMargin';
    /**
     * Used dashicon.
     *
     * @var string
     */
    public $dashicon = 'editor-expand';
    /**
     * C'tor.
     *
     * @param WP_Customize_Manager $manager
     * @param string $id
     * @param array $args
     */
    public function __construct($manager, $id, $args = []) {
        parent::__construct($manager, $id, $args);
    }
    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function json() {
        return \array_merge(parent::json(), ['dashicon' => $this->dashicon]);
    }
}
