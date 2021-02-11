<?php

namespace DevOwl\RealCookieBanner\presets;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\view\customize\banner\BasicLayout;
use DevOwl\RealCookieBanner\view\customize\banner\individual\Group;
use DevOwl\RealCookieBanner\view\customize\banner\individual\Texts as IndividualTexts;
use DevOwl\RealCookieBanner\view\customize\banner\Legal;
use DevOwl\RealCookieBanner\view\customize\banner\Texts;
use ReflectionClass;
use DevOwl\RealCookieBanner\view\customize\banner\Design;
use DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign;
use DevOwl\RealCookieBanner\view\customize\banner\BodyDesign;
use DevOwl\RealCookieBanner\view\customize\banner\FooterDesign;
use DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton;
use DevOwl\RealCookieBanner\view\customize\banner\individual\Layout;
use DevOwl\RealCookieBanner\view\customize\banner\Decision;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Predefined presets for cookie banner.
 */
class BannerPresets {
    use UtilsProvider;
    /**
     * Get all available presets.
     */
    public function get() {
        /**
         * Filters available presets for cookie banner customize.
         *
         * @hook RCB/Presets/Banner
         * @param {array} $presets All available presets
         * @returns {array}
         */
        return apply_filters('RCB/Presets/Banner', [
            'light' => [
                'name' => __('Light Dialog', RCB_TD),
                'description' => __('Standard design for the cookie consent as a dialog.', RCB_TD),
                'settings' => []
            ],
            'light-banner' => [
                'name' => __('Light Banner', RCB_TD),
                'description' => __('Standard design for the cookie consent as a banner.', RCB_TD),
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_OUT => 'fadeOut',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 47,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#e5e5e5'
                ]
            ],
            'dark' => [
                'name' => __('Dark Dialog', RCB_TD),
                'description' => __('Standard design for the cookie consent as a dialog in dark mode.', RCB_TD),
                'needsPro' => \true,
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_COLOR_BG => '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#f9f9f9',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 3,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#0a0a0a',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#f9f9f9',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                        '#424242',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                        '#056363',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_INHERIT_FONT_SIZE => \false,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                        '#056363',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                        '#056363',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                        '#067070',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                        '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                        '#067d7d',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                        '#067070',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                        '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                        '#078a8a',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                        '#067d7d',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                        '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                        '#d3d3d3',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#141414',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 1,
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_COLOR => '#424242',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR => '#d3d3d3',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_COLOR =>
                        '#f9f9f9',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                        '#067070',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                        '#056363',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                        '#424242',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                        '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                        '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR => '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                        '#d3d3d3',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                        '#067d7d',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                        '#067d7d',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG => '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                        '#067070',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                        '#067070'
                ]
            ],
            'dark-banner' => [
                'name' => __('Dark Banner', RCB_TD),
                'description' => __('Standard design for the cookie consent as a banner in dark mode.', RCB_TD),
                'needsPro' => \true,
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_OUT => 'fadeOut',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_COLOR_BG => '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#f9f9f9',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 3,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#0a0a0a',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#f9f9f9',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                        '#424242',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                        '#056363',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_INHERIT_FONT_SIZE => \false,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                        '#056363',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                        '#056363',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                        '#067070',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                        '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                        '#067d7d',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                        '#067070',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                        '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                        '#078a8a',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                        '#067d7d',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                        '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                        '#d3d3d3',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#141414',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 1,
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_COLOR => '#424242',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR => '#d3d3d3',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_COLOR =>
                        '#f9f9f9',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                        '#067070',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                        '#056363',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                        '#424242',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                        '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                        '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR => '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                        '#d3d3d3',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                        '#067d7d',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                        '#067d7d',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG => '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                        '#067070',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                        '#067070'
                ]
            ],
            'divi-dialog' => [
                'name' => __('Divi Dialog', RCB_TD),
                'description' => __('Optimized design for the standard Divi theme as a consent dialog.', RCB_TD),
                'needsPro' => \true,
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_MAX_WIDTH => 420,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_INHERIT_FAMILY => \true,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 3,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#666666',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [19, 20, 17, 20],
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 26,
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                        '#e2e2e2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                        '#2993d9',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                        '#278acc',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                        '#278acc',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_INHERIT_BG => \true,
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 1,
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_COLOR => '#e2e2e2',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR => '#2b2b2b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DIALOG_MAX_WIDTH => 825,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                        '#2993d9',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_WIDTH => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                        '#278acc',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                        '#278acc'
                ]
            ],
            'divi-banner' => [
                'name' => __('Divi Banner', RCB_TD),
                'description' => __('Optimized design for the standard Divi theme as a consent banner.', RCB_TD),
                'needsPro' => \true,
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_MAX_WIDTH => 420,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_OUT => 'fadeOut',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_INHERIT_FAMILY => \true,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => -3,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#666666',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [21, 20, 19, 20],
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 26,
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                        '#e2e2e2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                        '#2993d9',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                        '#278acc',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                        '#278acc',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_INHERIT_BG => \true,
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [17, 20, 21, 20],
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 1,
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_COLOR => '#e2e2e2',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR => '#2b2b2b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DIALOG_MAX_WIDTH => 825,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                        '#2993d9',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_WIDTH => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                        '#2ea3f2',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                        '#278acc',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                        '#278acc'
                ]
            ],
            'astra-dialog' => [
                'name' => __('Astra Dialog', RCB_TD),
                'description' => __('Optimized design for the standard Astra theme as a consent dialog.', RCB_TD),
                'needsPro' => \true,
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_MAX_WIDTH => 420,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 1,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#3a3a3a',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 81,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 15,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [19, 30, 17, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 21,
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                        '#f5f5f5',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 30, 20, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                        '#0264a6',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                        '#0264a6',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                        '#0264a6',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                        '#3a3a3a',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                        '#141414',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#f5f5f5',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [19, 30, 21, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#3a3a3a',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR => '#141414',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                        '#c6c6c6',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                        '#0264a6',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                        20,
                        20,
                        20,
                        20
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                        '#c6c6c6',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                        '#0264a6',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                        '#0264a6'
                ]
            ],
            'astra-banner' => [
                'name' => __('Astra Banner', RCB_TD),
                'description' => __('Optimized design for the standard Astra theme as a consent banner.', RCB_TD),
                'needsPro' => \true,
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_MAX_WIDTH => 420,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BANNER_MAX_WIDTH => 800,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 1,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#3a3a3a',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 81,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 15,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [19, 30, 17, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 21,
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                        '#f5f5f5',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 30, 20, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                        '#0264a6',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                        '#0264a6',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                        '#0264a6',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                        '#3a3a3a',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                        '#141414',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#f5f5f5',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [19, 30, 21, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#3a3a3a',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR => '#141414',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_BANNER_MAX_WIDTH => 950,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                        '#c6c6c6',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                        '#0264a6',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                        20,
                        20,
                        20,
                        20
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                        '#c6c6c6',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                        '#0274be',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                        '#0264a6',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                        '#0264a6'
                ]
            ],
            'avada-dialog' => [
                'name' => __('Avada Dialog', RCB_TD),
                'description' => __('Optimized design for the standard Avada theme as a consent dialog.', RCB_TD),
                'needsPro' => \true,
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_MAX_WIDTH => 440,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#212934',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 57,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 16,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#4a4e57',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_INHERIT_FAMILY => \true,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#6d6d6d',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [17, 30, 15, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 26,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 30, 20, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_PADDING => [
                        12,
                        10,
                        12,
                        10
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                        '#58a36b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                        10,
                        5,
                        10,
                        5
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE => 16,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                        '#58a36b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                        '#58a36b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_PADDING => [
                        10,
                        5,
                        0,
                        5
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                        '#212934',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                        '#080a0d',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#1d242d',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [25, 30, 25, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#d2d3d5',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR => '#080a0d',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DIALOG_MAX_WIDTH => 885,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG => '#efefef',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                        '#e5e5e5',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                        '#e5e5e5',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                        10,
                        10,
                        10,
                        10
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_SIZE => 16,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                        '#58a36b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                        '#58a36b'
                ]
            ],
            'avada-banner' => [
                'name' => __('Avada Banner', RCB_TD),
                'description' => __('Optimized design for the standard Avada theme as a consent banner.', RCB_TD),
                'needsPro' => \true,
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_MAX_WIDTH => 440,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#212934',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 57,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 16,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#4a4e57',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_INHERIT_FAMILY => \true,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 2,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#6d6d6d',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [17, 30, 15, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 26,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 30, 20, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_PADDING => [
                        12,
                        10,
                        12,
                        10
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                        '#58a36b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                        10,
                        5,
                        10,
                        5
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE => 16,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                        '#58a36b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                        '#58a36b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_PADDING => [
                        10,
                        5,
                        0,
                        5
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_SIZE => 16,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                        '#212934',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                        '#080a0d',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#1d242d',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [25, 30, 25, 30],
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#d2d3d5',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR => '#080a0d',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DIALOG_MAX_WIDTH => 885,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG => '#efefef',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                        '#e5e5e5',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                        '#e5e5e5',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                        10,
                        10,
                        10,
                        10
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_SIZE => 16,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                        '#65bc7b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                        '#58a36b',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                        '#58a36b'
                ]
            ],
            'clean' => [
                'name' => __('Clean Dialog', RCB_TD),
                'description' => __('Clean design which suits perfect to themes without many colors.', RCB_TD),
                'needsPro' => \true,
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 9,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 50,
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BLUR => 4,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_LINK_TEXT_DECORATION => 'none',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => 4,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 27,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#6b6b6b',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [15, 20, 0, 20],
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 15,
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_WEIGHT => 'bold',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_WIDTH => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [10, 20, 0, 20],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                        '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_INHERIT_BG => \true,
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [7, 20, 11, 20],
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 1,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                        0,
                        0,
                        10,
                        0
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_WIDTH => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG => '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                        '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                        '#000000'
                ]
            ],
            'console-dark' => [
                'name' => __('Dark console', RCB_TD),
                'description' => __('Design that is oriented towards technical interfaces.', RCB_TD),
                'needsPro' => \true,
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\Decision::SETTING_ACCEPT_ESSENTIALS => 'link',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_COLOR_BG => '#1e1e1e',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BORDER_WIDTH => 1,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BORDER_COLOR => '#0a0a0a',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#dddddd',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_FAMILY =>
                        '"Courier New", Courier, monospace',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_X => -1,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => 3,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 20,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_SPREAD_RADIUS => 3,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#0a0a0a',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_INHERIT_BG => \false,
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BG => '#161616',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#f9f9f9',
                    \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                        '#0f0f0f',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                        '#21d18b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_INHERIT_FONT_SIZE => \false,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                        '#21d18b',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                        '#319e57',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BORDER_WIDTH => 1,
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                        '#2b8c4d',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                        5,
                        5,
                        0,
                        5
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                        '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                        '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                        '#319e57',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                        '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                        '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                        '#067d7d',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                        '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                        '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#161616',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 1,
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_COLOR => '#0f0f0f',
                    \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR => '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DIALOG_MAX_WIDTH => 900,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG => '#191919',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                        '#000000',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_COLOR =>
                        '#f9f9f9',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                        '#319e57',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                        '#319e57',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                        15,
                        0,
                        0,
                        0
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 5,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_WIDTH => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                        '#161616',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                        '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                        '#dddddd',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR => '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                        '#d3d3d3',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_TYPE => 'link',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                        0,
                        5,
                        5,
                        5
                    ],
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                        '#969696',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                        '#067d7d',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG => '#222222',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                        '#ffffff',
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                        '#067070'
                ]
            ]
        ]);
    }
    /**
     * Default values so the presets only override a set of settings.
     */
    public function defaults() {
        $sectionArgs = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getBanner()
            ->getCustomize()
            ->getSections();
        $defaults = [];
        foreach ($sectionArgs as $sectionId => $section) {
            // Legal and texts should be ignored as they are not really "styles" and preset-relevant
            if (
                \in_array(
                    $sectionId,
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\Legal::SECTION,
                        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SECTION,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SECTION
                    ],
                    \true
                )
            ) {
                continue;
            }
            foreach ($section['controls'] as $controlId => $control) {
                $setting = isset($control['setting']) ? $control['setting'] : null;
                if (isset($setting)) {
                    $defaults[$controlId] = isset($setting['default']) ? $setting['default'] : \false;
                }
            }
        }
        return $defaults;
    }
    /**
     * Return PHP constant names. This is meant to be so on frontend a PHP code can be
     * generated for a preset easily.
     */
    public function constants() {
        return \array_merge(
            $this->constantsFromFolder(
                RCB_INC . 'view/customize/banner/*.php',
                \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::class
            ),
            $this->constantsFromFolder(
                RCB_INC . 'view/customize/banner/individual/*.php',
                \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::class
            )
        );
    }
    /**
     * Does not support recursive folders.
     *
     * @param string $glob
     * @param string $baseClass
     */
    protected function constantsFromFolder($glob, $baseClass) {
        $result = [];
        $classFiles = \glob($glob);
        foreach ($classFiles as $classPath) {
            // Get full qualified name for the class
            $className = \explode('.', \basename($classPath))[0];
            if ($className === 'index') {
                continue;
            }
            $fq = \explode('\\', $baseClass);
            \array_pop($fq);
            \array_push($fq, $className);
            $fq = \join('\\', $fq);
            // Iterate all SETTING_ constants
            $reflection = new \ReflectionClass($fq);
            foreach ($reflection->getConstants() as $constant => $value) {
                if (\substr($constant, 0, 8) === 'SETTING_') {
                    $result[$value] = '\\' . $fq . '::' . $constant;
                }
            }
        }
        return $result;
    }
}
