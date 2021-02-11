<?php

namespace DevOwl\RealCookieBanner\view\customize\banner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\TinyMCE;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\settings\Consent;
use DevOwl\RealCookieBanner\view\BannerCustomize;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Cookie banner texts.
 */
class Texts {
    use UtilsProvider;
    const SECTION = \DevOwl\RealCookieBanner\view\BannerCustomize::PANEL_MAIN . '-texts';
    const HEADLINE_GENERAL = self::SECTION . '-headline-general';
    const HEADLINE_EPRIVACY_USA = self::SECTION . '-headline-eprivacy-usa';
    const HEADLINE_AGE_NOTICE = self::SECTION . '-headline-age-notice';
    const SETTING = RCB_OPT_PREFIX . '-banner-texts';
    const SETTING_HEADLINE = self::SETTING . '-headline';
    const SETTING_DESCRIPTION = self::SETTING . '-description';
    const SETTING_EPRIVACY_USA = self::SETTING . '-eprivacy-usa';
    const SETTING_AGE_NOTICE = self::SETTING . '-age-notice';
    const SETTING_AGE_NOTICE_BLOCKER = self::SETTING . '-age-notice-blocker';
    const SETTING_ACCEPT_ALL = self::SETTING . '-accept-all';
    const SETTING_ACCEPT_ESSENTIALS = self::SETTING . '-accept-essentials';
    const SETTING_ACCEPT_INDIVIDUAL = self::SETTING . '-accept-individual';
    /**
     * Return arguments for this section.
     */
    public function args() {
        $defaultButtonTexts = self::getDefaultButtonTexts();
        $ePrivacyUSAEnabled = \DevOwl\RealCookieBanner\settings\Consent::getInstance()->isEPrivacyUSAEnabled();
        $ageNoticeEnabled = \DevOwl\RealCookieBanner\settings\Consent::getInstance()->isAgeNoticeEnabled();
        return [
            'name' => 'texts',
            'title' => __('Texts', RCB_TD),
            'controls' => [
                self::HEADLINE_GENERAL => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'label' => __('General', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true
                ],
                self::SETTING_HEADLINE => [
                    'name' => 'headline',
                    'label' => __('Headline', RCB_TD),
                    'setting' => ['default' => $defaultButtonTexts['headline'], 'allowEmpty' => \true]
                ],
                self::SETTING_DESCRIPTION => [
                    'name' => 'description',
                    'label' => __('Description', RCB_TD),
                    'type' => 'textarea',
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\TinyMCE::class,
                    'setting' => [
                        'default' => $defaultButtonTexts['description'],
                        'sanitize_callback' => 'wp_kses_post',
                        'allowEmpty' => \true
                    ]
                ],
                self::SETTING_ACCEPT_ALL => [
                    'name' => 'acceptAll',
                    'label' => __('"Accept all cookies" button/link', RCB_TD),
                    'setting' => ['default' => $defaultButtonTexts['acceptAll']]
                ],
                self::SETTING_ACCEPT_ESSENTIALS => [
                    'name' => 'acceptEssentials',
                    'label' => __('"Accept only essential cookies" button/link', RCB_TD),
                    'setting' => ['default' => $defaultButtonTexts['acceptEssentials']]
                ],
                self::SETTING_ACCEPT_INDIVIDUAL => [
                    'name' => 'acceptIndividual',
                    'label' => __('"Individual privacy preferences" button/link', RCB_TD),
                    'setting' => ['default' => $defaultButtonTexts['acceptIndividual']]
                ],
                self::HEADLINE_EPRIVACY_USA => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'label' => __('US data processing', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true,
                    'description' => $ePrivacyUSAEnabled
                        ? __(
                            'Use <code>{{services}}</code> as a placeholder to show all cookies/services that process data in the USA.',
                            RCB_TD
                        )
                        : $this->getEPrivacyUSANotice()
                ],
                self::SETTING_EPRIVACY_USA => [
                    'name' => 'ePrivacyUSA',
                    'label' => __('Data processing in the USA', RCB_TD),
                    'type' => 'textarea',
                    'input_attrs' => $ePrivacyUSAEnabled ? [] : ['disabled' => 'disabled'],
                    'class' => $ePrivacyUSAEnabled
                        ? \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\TinyMCE::class
                        : null,
                    'setting' => [
                        'default' => $defaultButtonTexts['ePrivacyUSA'],
                        'sanitize_callback' => 'wp_kses_post',
                        'allowEmpty' => \true
                    ]
                ],
                self::HEADLINE_AGE_NOTICE => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'label' => __('Age notice', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true,
                    'description' => $ageNoticeEnabled ? '' : $this->getAgeNoticeNotice()
                ],
                self::SETTING_AGE_NOTICE => [
                    'name' => 'ageNoticeBanner',
                    'label' => __('Age notice in cookie banner', RCB_TD),
                    'type' => 'textarea',
                    'input_attrs' => $ageNoticeEnabled ? [] : ['disabled' => 'disabled'],
                    'class' => $ageNoticeEnabled
                        ? \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\TinyMCE::class
                        : null,
                    'setting' => [
                        'default' => $defaultButtonTexts['ageNoticeBanner'],
                        'sanitize_callback' => 'wp_kses_post',
                        'allowEmpty' => \true
                    ]
                ],
                self::SETTING_AGE_NOTICE_BLOCKER => [
                    'name' => 'ageNoticeBlocker',
                    'label' => __('Age notice in content blocker', RCB_TD),
                    'type' => 'textarea',
                    'input_attrs' => $ageNoticeEnabled ? [] : ['disabled' => 'disabled'],
                    'class' => $ageNoticeEnabled
                        ? \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\TinyMCE::class
                        : null,
                    'setting' => [
                        'default' => $defaultButtonTexts['ageNoticeBlocker'],
                        'sanitize_callback' => 'wp_kses_post',
                        'allowEmpty' => \true
                    ]
                ]
            ]
        ];
    }
    /**
     * Return a notice HTML for the customize description when US data processing is deactivated.
     */
    public static function getEPrivacyUSANotice() {
        return \sprintf(
            '<div class="notice notice-info inline below-h2 notice-alt" style="margin: 10px 0px 0px;"><p>%s</p></div>',
            \sprintf(
                // translators:
                __(
                    'Consent for data processing in the USA is currently disabled. Please navigate to %1$sSettings > Consent%2$s to activate it.',
                    RCB_TD
                ),
                '<a href="' .
                    esc_attr(
                        \DevOwl\RealCookieBanner\Core::getInstance()
                            ->getConfigPage()
                            ->getUrl()
                    ) .
                    '#/settings/consent" target="_blank">',
                '</a>'
            )
        );
    }
    /**
     * Return a notice HTML for the customize description when age notice is deactivated.
     */
    public static function getAgeNoticeNotice() {
        return \sprintf(
            '<div class="notice notice-info inline below-h2 notice-alt" style="margin: 10px 0px 0px;"><p>%s</p></div>',
            \sprintf(
                // translators:
                __(
                    'Age notice is currently disabled. Please navigate to %1$sSettings > Consent%2$s to activate it.',
                    RCB_TD
                ),
                '<a href="' .
                    esc_attr(
                        \DevOwl\RealCookieBanner\Core::getInstance()
                            ->getConfigPage()
                            ->getUrl()
                    ) .
                    '#/settings/consent" target="_blank">',
                '</a>'
            )
        );
    }
    /**
     * Get the button default texts.
     */
    public static function getDefaultButtonTexts() {
        $tempTd = \DevOwl\RealCookieBanner\comp\language\Hooks::getInstance()->createTemporaryTextDomain();
        $defaults = [
            'headline' => __('Privacy preferences', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            'description' => __(
                'We use cookies on our website. Some of them are essential, while others help us to improve this website and your experience. You have the right to consent to only essential cookies and to revoke your consent of any kind at a later date.',
                \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
            ),
            'acceptAll' => __('Accept all cookies', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            'acceptEssentials' => __(
                'Accept only essential cookies',
                \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
            ),
            'acceptIndividual' => __(
                'Individual privacy preferences',
                \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
            ),
            'ePrivacyUSA' => __(
                'The following services used on this website collect data and process them in the USA: {{services}}. By agreeing to the use of these services, you also consent to your data being processed in the USA in accordance with Art. 49 para. 1 sentence 1 lit. a EU GDPR. The USA is considered by the ECJ to be a country with a level of data protection that is inadequate by EU standards. In particular, there is a risk that your data may be processed by US authorities for control and monitoring purposes, possibly without the possibility of legal recourse. This may result in disadvantages for you such as being refused entry to the USA.',
                \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
            ),
            'ageNoticeBanner' => __(
                'You are under 16 years old? Then you can only accept essential cookies, or you can ask your parents or legal guardian to agree with you to other cookies.',
                \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
            ),
            'ageNoticeBlocker' => __(
                'You are under 16 years old? Unfortunately, you are not allowed to agree to these cookies yourself to view this content. Please ask your parents or legal guardian to agree to the cookies with you.',
                \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
            )
        ];
        $tempTd->teardown();
        return $defaults;
    }
}
