<?php

namespace DevOwl\RealCookieBanner\view\customize\banner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CssMarginInput;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\view\BannerCustomize;
use WP_Customize_Color_Control;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Basic Layout.
 */
class BasicLayout {
    use UtilsProvider;
    const SECTION = \DevOwl\RealCookieBanner\view\BannerCustomize::PANEL_MAIN . '-layout';
    const HEADLINE_OVERLAY = self::SECTION . '-headline-overlay';
    const HEADLINE_ANIMATION_IN = self::SECTION . '-headline-animation-in';
    const HEADLINE_ANIMATION_OUT = self::SECTION . '-headline-animation-out';
    const SETTING = RCB_OPT_PREFIX . '-banner-layout';
    const SETTING_TYPE = self::SETTING . '-type';
    const SETTING_DIALOG_POSITION = self::SETTING . '-dialog-position';
    const SETTING_DIALOG_MARGIN = self::SETTING . '-dialog-margin';
    const SETTING_DIALOG_MAX_WIDTH = self::SETTING . '-dialog-max-width';
    const SETTING_BANNER_POSITION = self::SETTING . '-banner-position';
    const SETTING_BANNER_MAX_WIDTH = self::SETTING . '-banner-max-width';
    const SETTING_OVERLAY = self::SETTING . '-overlay';
    const SETTING_OVERLAY_BG = self::SETTING . '-overlayBg';
    const SETTING_OVERLAY_BG_ALPHA = self::SETTING . '-overlayBgAlpha';
    const SETTING_OVERLAY_BLUR = self::SETTING . '-overlayBlur';
    const SETTING_ANIMATION_IN = self::SETTING . '-animation-in';
    const SETTING_ANIMATION_IN_DURATION = self::SETTING . '-animation-in-duration';
    const SETTING_ANIMATION_OUT = self::SETTING . '-animation-out';
    const SETTING_ANIMATION_OUT_DURATION = self::SETTING . '-animation-out-duration';
    const SETTING_BORDER_RADIUS = self::SETTING . '-border-radius';
    const SETTING_DIALOG_BORDER_RADIUS = self::SETTING . '-dialog-border-radius';
    const DEFAULT_TYPE = 'dialog';
    const DEFAULT_DIALOG_POSITION = 'middleCenter';
    const DEFAULT_DIALOG_MARGIN = [0, 0, 0, 0];
    const DEFAULT_DIALOG_MAX_WIDTH = 400;
    const DEFAULT_BANNER_POSITION = 'bottom';
    const DEFAULT_BANNER_MAX_WIDTH = 700;
    const DEFAULT_OVERLAY = \true;
    const DEFAULT_OVERLAY_BG = '#0a0a0a';
    const DEFAULT_OVERLAY_BG_ALPHA = 38;
    const DEFAULT_OVERLAY_BLUR = 0;
    const DEFAULT_ANIMATION_IN = 'none';
    const DEFAULT_ANIMATION_IN_DURATION = 1000;
    const DEFAULT_ANIMATION_OUT = 'none';
    const DEFAULT_ANIMATION_OUT_DURATION = 500;
    const DEFAULT_BORDER_RADIUS = 3;
    const DEFAULT_DIALOG_BORDER_RADIUS = 3;
    /**
     * Return arguments for this section.
     */
    public function args() {
        return [
            'name' => 'layout',
            'title' => __('Basic Layout', RCB_TD),
            'controls' => [
                self::SETTING_TYPE => [
                    'name' => 'type',
                    'label' => __('Layout', RCB_TD),
                    'type' => 'radio',
                    'choices' => ['dialog' => __('Dialog', RCB_TD), 'banner' => __('Banner', RCB_TD)],
                    'setting' => ['default' => self::DEFAULT_TYPE]
                ],
                self::SETTING_DIALOG_MAX_WIDTH => [
                    'name' => 'dialogMaxWidth',
                    'label' => __('Maximum width (px)', RCB_TD),
                    'type' => 'number',
                    'input_attrs' => ['step' => 5, 'min' => 200],
                    'setting' => ['default' => self::DEFAULT_DIALOG_MAX_WIDTH, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_DIALOG_POSITION => [
                    'name' => 'dialogPosition',
                    'label' => __('Position', RCB_TD),
                    'type' => 'select',
                    'choices' => [
                        'topLeft' => __('Top left', RCB_TD),
                        'topCenter' => __('Top center', RCB_TD),
                        'topRight' => __('Top right', RCB_TD),
                        'middleLeft' => __('Middle left', RCB_TD),
                        'middleCenter' => __('Center', RCB_TD),
                        'middleRight' => __('Middle right', RCB_TD),
                        'bottomLeft' => __('Bottom left', RCB_TD),
                        'bottomCenter' => __('Bottom center', RCB_TD),
                        'bottomRight' => __('Bottom right', RCB_TD)
                    ],
                    'setting' => ['default' => self::DEFAULT_DIALOG_POSITION]
                ],
                self::SETTING_DIALOG_MARGIN => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CssMarginInput::class,
                    'name' => 'dialogMargin',
                    'label' => __('Margin', RCB_TD),
                    'description' => __('Define outer distance of the dialog.', RCB_TD),
                    'setting' => ['default' => self::DEFAULT_DIALOG_MARGIN]
                ],
                self::SETTING_BANNER_POSITION => [
                    'name' => 'bannerPosition',
                    'label' => __('Position', RCB_TD),
                    'type' => 'select',
                    'choices' => ['top' => __('Top', RCB_TD), 'bottom' => __('Bottom', RCB_TD)],
                    'setting' => ['default' => self::DEFAULT_BANNER_POSITION]
                ],
                self::SETTING_BANNER_MAX_WIDTH => [
                    'name' => 'bannerMaxWidth',
                    'label' => __('Maximum content width (px)', RCB_TD),
                    'type' => 'number',
                    'input_attrs' => ['step' => 5, 'min' => 200],
                    'setting' => ['default' => self::DEFAULT_BANNER_MAX_WIDTH, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_DIALOG_BORDER_RADIUS => [
                    'name' => 'dialogBorderRadius',
                    'label' => __('Dialog border radius', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => ['min' => 0, 'max' => 50, 'step' => 0],
                    'setting' => ['default' => self::DEFAULT_DIALOG_BORDER_RADIUS, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_BORDER_RADIUS => [
                    'name' => 'borderRadius',
                    'label' => __('Button border radius', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => ['min' => 0, 'max' => 50, 'step' => 0],
                    'setting' => ['default' => self::DEFAULT_BORDER_RADIUS, 'sanitize_callback' => 'absint']
                ],
                self::HEADLINE_ANIMATION_IN => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'label' => __('Animation on display', RCB_TD)
                ],
                self::SETTING_ANIMATION_IN => [
                    'name' => 'animationIn',
                    'label' => __('Type', RCB_TD),
                    'type' => 'select',
                    'choices' => $this->getAvailableAnimations(),
                    'setting' => ['default' => self::DEFAULT_ANIMATION_IN]
                ],
                self::SETTING_ANIMATION_IN_DURATION => [
                    'name' => 'animationInDuration',
                    'label' => __('Duration (milliseconds)', RCB_TD),
                    'type' => 'number',
                    'input_attrs' => ['step' => 500, 'min' => 0],
                    'setting' => ['default' => self::DEFAULT_ANIMATION_IN_DURATION, 'sanitize_callback' => 'absint']
                ],
                self::HEADLINE_ANIMATION_OUT => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'label' => __('Animation on hide', RCB_TD)
                ],
                self::SETTING_ANIMATION_OUT => [
                    'name' => 'animationOut',
                    'label' => __('Type', RCB_TD),
                    'type' => 'select',
                    'choices' => $this->getAvailableAnimationsOut(),
                    'setting' => ['default' => self::DEFAULT_ANIMATION_OUT]
                ],
                self::SETTING_ANIMATION_OUT_DURATION => [
                    'name' => 'animationOutDuration',
                    'label' => __('Duration (milliseconds)', RCB_TD),
                    'type' => 'number',
                    'input_attrs' => ['step' => 500, 'min' => 0],
                    'setting' => ['default' => self::DEFAULT_ANIMATION_OUT_DURATION, 'sanitize_callback' => 'absint']
                ],
                self::HEADLINE_OVERLAY => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'label' => __('Overlay', RCB_TD),
                    'description' => __(
                        'The overlay prevents clicks outside the cookie box until consent is given.',
                        RCB_TD
                    )
                ],
                self::SETTING_OVERLAY => [
                    'name' => 'overlay',
                    'label' => __('Block content until consent', RCB_TD),
                    'type' => 'checkbox',
                    'setting' => [
                        'default' => self::DEFAULT_OVERLAY,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::SETTING_OVERLAY_BG => [
                    'name' => 'overlayBg',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Overlay background color', RCB_TD),
                    'setting' => ['default' => self::DEFAULT_OVERLAY_BG, 'sanitize_callback' => 'sanitize_hex_color']
                ],
                self::SETTING_OVERLAY_BG_ALPHA => [
                    'name' => 'overlayBgAlpha',
                    'label' => __('Overlay opacity', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => ['min' => 0, 'max' => 100, 'step' => 0],
                    'setting' => ['default' => self::DEFAULT_OVERLAY_BG_ALPHA, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_OVERLAY_BLUR => [
                    'name' => 'overlayBlur',
                    'label' => __('Blur effect', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => \array_merge(
                        ['min' => 0, 'max' => 20, 'step' => 0],
                        $this->isPro() ? [] : ['disabled' => 'disabled']
                    ),
                    'setting' => ['default' => self::DEFAULT_OVERLAY_BLUR, 'sanitize_callback' => 'absint']
                ]
            ]
        ];
    }
    /**
     * Get all available animate.css animations.
     */
    protected function getAvailableAnimations() {
        /**
         * Allows to provide additional animations-in compatible with animate.css.
         *
         * @hook RCB/Customize/Animation/In
         * @param {string[]} $animations
         * @return {string[]}
         */
        $result = apply_filters('RCB/Customize/Animation/In', ['none' => __('None', RCB_TD), 'fadeIn' => 'fadeIn']);
        \asort($result);
        return $result;
    }
    /**
     * Get all available animate.css animations for exit.
     */
    protected function getAvailableAnimationsOut() {
        /**
         * Allows to provide additional animations-out compatible with animate.css.
         *
         * @hook RCB/Customize/Animation/Out
         * @param {string[]} $animations
         * @return {string[]}
         */
        $result = apply_filters('RCB/Customize/Animation/Out', ['none' => __('None', RCB_TD), 'fadeOut' => 'fadeOut']);
        \asort($result);
        return $result;
    }
}