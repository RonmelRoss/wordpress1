<?php

namespace DevOwl\RealCookieBanner\view\customize\banner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\view\BannerCustomize;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Content decision options.
 */
class Decision {
    use UtilsProvider;
    const SECTION = \DevOwl\RealCookieBanner\view\BannerCustomize::PANEL_MAIN . '-decision';
    const CUSTOM_HTML_LEGAL_NOTICE_ALL = self::SECTION . '-custom-html-legal-notice-all';
    const CUSTOM_HTML_LEGAL_NOTICE_ESSENTIALS = self::SECTION . '-custom-html-legal-notice-essentials';
    const CUSTOM_HTML_LEGAL_NOTICE_INDIVIDUAL = self::SECTION . '-custom-html-legal-notice-individual';
    const SETTING = RCB_OPT_PREFIX . '-banner-decision';
    const SETTING_ACCEPT_ALL = self::SETTING . '-accept-all';
    const SETTING_ACCEPT_ESSENTIALS = self::SETTING . '-accept-essentials';
    const SETTING_ACCEPT_INDIVIDUAL = self::SETTING . '-accept-individual';
    const SETTING_GROUPS_FIRST_VIEW = self::SETTING . '-groups-first-view';
    const SETTING_SAVE_BUTTON = self::SETTING . '-save-button';
    const DEFAULT_ACCEPT_ALL = 'button';
    const DEFAULT_ACCEPT_ESSENTIALS = 'button';
    const DEFAULT_ACCEPT_INDIVIDUAL = 'link';
    const DEFAULT_GROUPS_FIRST_VIEW = \false;
    const DEFAULT_SAVE_BUTTON = 'always';
    /**
     * Return arguments for this section.
     */
    public function args() {
        $textLegalNotice = \sprintf(
            '<div class="notice notice-warning inline below-h2 notice-alt" style="margin: 10px 0 0 0"><p>%s</p></div>',
            __(
                'Please note that from a legal perspective you must give this option to your visitor. With the currently selected setting you take a risk.',
                RCB_TD
            )
        );
        return [
            'name' => 'decision',
            'title' => __('Consent options', RCB_TD),
            'controls' => [
                self::SETTING_ACCEPT_ALL => [
                    'name' => 'acceptAll',
                    'label' => __('Accept all cookies', RCB_TD),
                    'description' => __(
                        'According to the ePrivacy Directive (EU 2016/679), recital 32, you may not pre-select cookies in the form of pre-selected checkboxes for the visitor. However, the ePrivacy Directive does not prohibit the use of a button to agree to all cookies, if there is also a button to agree only to the essential cookies or to make a user-defined selection.',
                        RCB_TD
                    ),
                    'type' => 'select',
                    'choices' => [
                        'button' => __('Button', RCB_TD),
                        'link' => __('Link', RCB_TD),
                        'hide' => __('Hide', RCB_TD)
                    ],
                    'setting' => ['default' => self::DEFAULT_ACCEPT_ALL]
                ],
                self::CUSTOM_HTML_LEGAL_NOTICE_ALL => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML::class,
                    'name' => 'customHtmlDecisionLegalNoticeAll',
                    'description' => $textLegalNotice
                ],
                self::SETTING_ACCEPT_ESSENTIALS => [
                    'name' => 'acceptEssentials',
                    'label' => __('Accept only essential cookies', RCB_TD),
                    'description' => __(
                        'The ePrivacy Directive (EU 2016/679) defines that visitors must be able to easily reject cookies, whereby essential cookies can be set in any case. Therefore, the visitor should be given this option in a similar manner to the "Accept all cookies" button/link.',
                        RCB_TD
                    ),
                    'type' => 'select',
                    'choices' => [
                        'button' => __('Button', RCB_TD),
                        'link' => __('Link', RCB_TD),
                        'hide' => __('Hide', RCB_TD)
                    ],
                    'setting' => ['default' => self::DEFAULT_ACCEPT_ESSENTIALS]
                ],
                self::CUSTOM_HTML_LEGAL_NOTICE_ESSENTIALS => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML::class,
                    'name' => 'customHtmlDecisionLegalNoticeEssentials',
                    'description' => $textLegalNotice
                ],
                self::SETTING_ACCEPT_INDIVIDUAL => [
                    'name' => 'acceptIndividual',
                    'label' => __('Individual privacy preferences', RCB_TD),
                    'description' => __(
                        'According to the ePrivacy Directive (EU 2016/679), the user must be free to choose which cookies should be set and be informed about their purpose before giving his consent. Therefore, the user must be given the opportunity to access the individual privacy preferences page.',
                        RCB_TD
                    ),
                    'type' => 'select',
                    'choices' => [
                        'button' => __('Button', RCB_TD),
                        'link' => __('Link', RCB_TD),
                        'hide' => __('Hide', RCB_TD)
                    ],
                    'setting' => ['default' => self::DEFAULT_ACCEPT_INDIVIDUAL]
                ],
                self::CUSTOM_HTML_LEGAL_NOTICE_INDIVIDUAL => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML::class,
                    'name' => 'customHtmlDecisionLegalNoticeIndividual',
                    'description' => $textLegalNotice
                ],
                self::SETTING_GROUPS_FIRST_VIEW => [
                    'name' => 'groupsFirstView',
                    'label' => __('Custom choice in first view', RCB_TD),
                    'type' => 'rcbGroupsFirstView',
                    'setting' => [
                        'default' => self::DEFAULT_GROUPS_FIRST_VIEW,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::SETTING_SAVE_BUTTON => [
                    'name' => 'saveButton',
                    'label' => __('Save button', RCB_TD),
                    'type' => 'radio',
                    'choices' => [
                        'always' => __('Show save button always', RCB_TD),
                        'afterChange' => __('Show save button only after a change by the user', RCB_TD),
                        'afterChangeAll' => __('Text of "Accept all cookies" changes, if user change choice', RCB_TD)
                    ],
                    'setting' => ['default' => self::DEFAULT_SAVE_BUTTON]
                ]
            ]
        ];
    }
}
