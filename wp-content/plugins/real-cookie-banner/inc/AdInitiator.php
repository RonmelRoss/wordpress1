<?php

namespace DevOwl\RealCookieBanner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\RealUtils\AbstractInitiator;
use DevOwl\RealCookieBanner\base\UtilsProvider;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Initiate real-utils functionality.
 */
class AdInitiator extends \DevOwl\RealCookieBanner\Vendor\DevOwl\RealUtils\AbstractInitiator {
    use UtilsProvider;
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function getPluginBase() {
        return $this;
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function getHeroButton() {
        return [
            __('Start configuration', RCB_TD),
            \DevOwl\RealCookieBanner\Core::getInstance()
                ->getConfigPage()
                ->getUrl()
        ];
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function getPluginAssets() {
        return $this->getCore()->getAssets();
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function getRateLink() {
        return 'https://devowl.io/go/wordpress-org/real-cookie-banner/rate';
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function getWelcomePageImageHeight() {
        return 280;
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function getKeyFeatures() {
        return [
            [
                'image' => $this->getAssetsUrl(__('key-features/presets.gif', RCB_TD)),
                'title' => __('Cookie & Consent Management', RCB_TD),
                'description' => __(
                    'You can store all technical and legal information about cookies and services to obtain qualified consent. 40+ cookie templates and 25+ content blocker templates will help you to quickly and securely add all information.',
                    RCB_TD
                )
            ],
            [
                'image' => $this->getAssetsUrl(__('key-features/content-blocker.gif', RCB_TD)),
                'title' => __('Content Blocker', RCB_TD),
                'description' => __(
                    'Themes, plugins and co. usually load scripts, styles and content that transfer data and set cookies before you have the consent of your visitors. Content Blockers make sure that these functions are only executed after the consent.',
                    RCB_TD
                )
            ],
            [
                'image' => $this->getAssetsUrl(__('key-features/customize-presets.gif', RCB_TD)),
                'title' => __('Customize design', RCB_TD),
                'description' => __(
                    'You can design the cookie banner according to your wishes. 10+ design presets and over 170 options give you the flexibility to customize the design to perfectly match with your corporate design. All changes are shown in a live preview.',
                    RCB_TD
                )
            ],
            [
                'image' => $this->getAssetsUrl(__('key-features/guided-configuration.gif', RCB_TD)),
                'title' => __('Guided configuration', RCB_TD),
                'description' => __(
                    'After installation, the checklist will guide you through all steps to set up Real Cookie Banner in a legally compliant manner. In addition, we explain the legal basis of features and legal consequences if you want to change settings.',
                    RCB_TD
                )
            ],
            [
                'image' => $this->getAssetsUrl(__('key-features/list-of-consents.gif', RCB_TD)),
                'title' => __('Documentation of consents', RCB_TD),
                'description' => __(
                    'The GDPR provides for a reversal of the burden of proof, which is why you must prove that a visitor has consented to cookies if he or she doubts it. We document consents completely and enable you to trace the origin of consent afterwards.',
                    RCB_TD
                )
            ],
            [
                'image' => $this->getAssetsUrl(__('key-features/native-menu.gif', RCB_TD)),
                'title' => __('Native solution in WordPress', RCB_TD),
                'description' => __(
                    'The content management is completely installed in your WordPress. You have no obligation to use a cloud service, which can raise further legal questions. So all data is in your hands, without dependence to a third server.',
                    RCB_TD
                )
            ]
        ];
    }
}
