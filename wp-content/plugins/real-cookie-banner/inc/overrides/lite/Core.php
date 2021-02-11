<?php

namespace DevOwl\RealCookieBanner\lite;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Freemium\CoreLite;
use DevOwl\RealCookieBanner\lite\rest\Service;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
use DevOwl\RealCookieBanner\presets\pro\ActiveCampaignSiteTrackingPreset;
use DevOwl\RealCookieBanner\presets\pro\AddThisPreset;
use DevOwl\RealCookieBanner\presets\pro\AddToAnyPreset;
use DevOwl\RealCookieBanner\presets\pro\AdobeTypekitPreset;
use DevOwl\RealCookieBanner\presets\pro\AmazonAssociatesWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\AnalytifyPreset;
use DevOwl\RealCookieBanner\presets\pro\AnchorFmPreset;
use DevOwl\RealCookieBanner\presets\pro\AppleMusicPreset;
use DevOwl\RealCookieBanner\presets\pro\BingMapsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ActiveCampaignFormPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AddThisPreset as BlockerAddThisPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AddToAnyPreset as BlockerAddToAnyPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AdobeTypekitPreset as BlockerAdobeTypekitPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AnalytifyPreset as BlockerAnalytifyPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AnchorFmPreset as BlockerAnchorFmPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AppleMusicPreset as BlockerAppleMusicPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\BingMapsPreset as BlockerBingMapsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\CalderaFormsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\CleverReachRecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ContactForm7RecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\CustomFacebookFeedPreset as BlockerCustomFacebookFeedPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\CustomTwitterFeedPreset as BlockerCustomTwitterFeedPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\DiscordWidgetPreset as BlockerDiscordWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ExactMetricsPreset as BlockerExactMetricsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookForWooCommercePreset as BlockerFacebookForWooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookLikePreset as BlockerFacebookLikePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPagePluginPreset as BlockerFacebookPagePluginPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPixelPreset as BlockerFacebookPixelPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPostPreset as BlockerFacebookPostPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookSharePreset as BlockerFacebookSharePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FeedsForYoutubePreset as BlockerFeedsForYoutubePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FlickrPreset as BlockerFlickrPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FormidablePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FormMakerRecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GAGoogleAnalyticsPreset as BlockerGAGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAnalyticsPreset as BlockerGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleMapsPreset as BlockerGoogleMapsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleRecaptchaPreset as BlockerGoogleRecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleTranslatePreset as BlockerGoogleTranslatePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleTrendsPreset as BlockerGoogleTrendsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ImgurPreset as BlockerImgurPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\InstagramPostPreset as BlockerInstagramPostPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MailchimpForWooCommercePreset as BlockerMailchimpForWooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MailerLitePreset as BlockerMailerLitePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MatomoPluginPreset as BlockerMatomoPluginPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MonsterInsightsPreset as BlockerMonsterInsightsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MyFontsPreset as BlockerMyFontsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\NinjaFormsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\PinterestPreset as BlockerPinterestPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ProvenExpertWidgetPreset as BlockerProvenExpertWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\RedditPreset as BlockerRedditPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\SpotifyPreset as BlockerSpotifyPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\TikTokPreset as BlockerTikTokPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\TwitterTweetPreset as BlockerTwitterTweetPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\VGWortPreset as BlockerVGWortPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\WooCommerceGoogleAnalyticsPreset as BlockerWooCommerceGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\WPFormsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ZohoBookingsPreset as BlockerZohoBookingsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ZohoFormsPreset as BlockerZohoFormsPreset;
use DevOwl\RealCookieBanner\presets\pro\CleanTalkSpamProtectPreset;
use DevOwl\RealCookieBanner\presets\pro\CloudflarePreset;
use DevOwl\RealCookieBanner\presets\pro\CustomFacebookFeedPreset;
use DevOwl\RealCookieBanner\presets\pro\CustomTwitterFeedPreset;
use DevOwl\RealCookieBanner\presets\pro\DiscordWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\ExactMetricsPreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookForWooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookLikePreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookPagePluginPreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookPixelPreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookPostPreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookSharePreset;
use DevOwl\RealCookieBanner\presets\pro\FeedsForYoutubePreset;
use DevOwl\RealCookieBanner\presets\pro\FlickrPreset;
use DevOwl\RealCookieBanner\presets\pro\FreshchatPreset;
use DevOwl\RealCookieBanner\presets\pro\GAGoogleAnalytics4Preset;
use DevOwl\RealCookieBanner\presets\pro\GAGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleAds;
use DevOwl\RealCookieBanner\presets\pro\GoogleAdSensePreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleAnalytics4Preset;
use DevOwl\RealCookieBanner\presets\pro\GoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleMapsPreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleRecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleTranslatePreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleTrendsPreset;
use DevOwl\RealCookieBanner\presets\pro\GtmPreset;
use DevOwl\RealCookieBanner\presets\pro\HelpCrunchChatPreset;
use DevOwl\RealCookieBanner\presets\pro\HelpScoutChatPreset;
use DevOwl\RealCookieBanner\presets\pro\HotjarPreset;
use DevOwl\RealCookieBanner\presets\pro\ImgurPreset;
use DevOwl\RealCookieBanner\presets\pro\InstagramPostPreset;
use DevOwl\RealCookieBanner\presets\pro\IntercomChatPreset;
use DevOwl\RealCookieBanner\presets\pro\LuckyOrangePreset;
use DevOwl\RealCookieBanner\presets\pro\MailchimpForWooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\MailerLitePreset;
use DevOwl\RealCookieBanner\presets\pro\MatomoPluginPreset;
use DevOwl\RealCookieBanner\presets\pro\MatomoPreset;
use DevOwl\RealCookieBanner\presets\pro\MicrosoftClarityPreset;
use DevOwl\RealCookieBanner\presets\pro\MonsterInsightsPreset;
use DevOwl\RealCookieBanner\presets\pro\MouseflowPreset;
use DevOwl\RealCookieBanner\presets\pro\MtmPreset;
use DevOwl\RealCookieBanner\presets\pro\MyFontsPreset;
use DevOwl\RealCookieBanner\presets\pro\PaddleComPreset;
use DevOwl\RealCookieBanner\presets\pro\PinterestPreset;
use DevOwl\RealCookieBanner\presets\pro\PolyLangPreset;
use DevOwl\RealCookieBanner\presets\pro\ProvenExpertWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\ReamazeChatPreset;
use DevOwl\RealCookieBanner\presets\pro\RedditPreset;
use DevOwl\RealCookieBanner\presets\pro\SpotifyPreset;
use DevOwl\RealCookieBanner\presets\pro\StripePreset;
use DevOwl\RealCookieBanner\presets\pro\TawkToChatPreset;
use DevOwl\RealCookieBanner\presets\pro\TidioChatPreset;
use DevOwl\RealCookieBanner\presets\pro\TikTokPreset;
use DevOwl\RealCookieBanner\presets\pro\TwitterTweetPreset;
use DevOwl\RealCookieBanner\presets\pro\UltimateMemberPreset;
use DevOwl\RealCookieBanner\presets\pro\UserlikePreset;
use DevOwl\RealCookieBanner\presets\pro\VGWortPreset;
use DevOwl\RealCookieBanner\presets\pro\WooCommerceGatewayStripePreset;
use DevOwl\RealCookieBanner\presets\pro\WooCommerceGoogleAnalytics4Preset;
use DevOwl\RealCookieBanner\presets\pro\WooCommerceGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\WooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\WordfencePreset;
use DevOwl\RealCookieBanner\presets\pro\WPMLPreset;
use DevOwl\RealCookieBanner\presets\pro\ZendeskChatPreset;
use DevOwl\RealCookieBanner\presets\pro\ZohoBookingsPreset;
use DevOwl\RealCookieBanner\presets\pro\ZohoFormsPreset;
use WP_Error;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
trait Core {
    use CoreLite;
    // Documented in IOverrideCore
    public function overrideConstruct() {
        add_filter('RCB/Presets/Cookies', [$this, 'createProCookiePresets']);
        add_filter('RCB/Presets/Blocker', [$this, 'createProBlockerPresets']);
    }
    // Documented in IOverrideCore
    public function overrideRegisterSettings() {
        // Silence is golden.
    }
    // Documented in IOverrideCore
    public function overrideInit() {
        add_action('rest_api_init', [\DevOwl\RealCookieBanner\lite\rest\Service::instance(), 'rest_api_init']);
    }
    /**
     * Create PRO-specific cookie presets.
     *
     * @param array $result
     */
    public function createProCookiePresets($result) {
        return \array_merge($result, [
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CLOUDFLARE =>
                \DevOwl\RealCookieBanner\presets\pro\CloudflarePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::POLYLANG =>
                \DevOwl\RealCookieBanner\presets\pro\PolyLangPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WPML =>
                \DevOwl\RealCookieBanner\presets\pro\WPMLPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\WooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ULTIMATE_MEMBER =>
                \DevOwl\RealCookieBanner\presets\pro\UltimateMemberPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GTM =>
                \DevOwl\RealCookieBanner\presets\pro\GtmPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MTM =>
                \DevOwl\RealCookieBanner\presets\pro\MtmPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_MAPS =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleMapsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_POST =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookPostPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::INSTAGRAM_POST =>
                \DevOwl\RealCookieBanner\presets\pro\InstagramPostPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TWITTER_TWEET =>
                \DevOwl\RealCookieBanner\presets\pro\TwitterTweetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleRecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MATOMO =>
                \DevOwl\RealCookieBanner\presets\pro\MatomoPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_AD_SENSE =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleAdSensePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_ADS =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleAds::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_PIXEL =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookPixelPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_LIKE =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookLikePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_SHARE =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookSharePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HOTJAR =>
                \DevOwl\RealCookieBanner\presets\pro\HotjarPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::AMAZON_ASSOCIATES_WIDGET =>
                \DevOwl\RealCookieBanner\presets\pro\AmazonAssociatesWidgetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::INTERCOM_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\IntercomChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZENDESK_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\ZendeskChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FRESHCHAT =>
                \DevOwl\RealCookieBanner\presets\pro\FreshchatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HELP_CRUNCH_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\HelpCrunchChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HELP_SCOUT_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\HelpScoutChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TIDIO_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\TidioChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TAWK_TO_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\TawkToChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::REAMAZE_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\ReamazeChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PINTEREST =>
                \DevOwl\RealCookieBanner\presets\pro\PinterestPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::IMGUR =>
                \DevOwl\RealCookieBanner\presets\pro\ImgurPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_TRANSLATE =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleTranslatePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADOBE_TYPEKIT =>
                \DevOwl\RealCookieBanner\presets\pro\AdobeTypekitPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_PAGE_PLUGIN =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookPagePluginPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FLICKR =>
                \DevOwl\RealCookieBanner\presets\pro\FlickrPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::VG_WORT =>
                \DevOwl\RealCookieBanner\presets\pro\VGWortPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PADDLE_COM =>
                \DevOwl\RealCookieBanner\presets\pro\PaddleComPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_ANALYTICS_4 =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleAnalytics4Preset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MICROSOFT_CLARITY =>
                \DevOwl\RealCookieBanner\presets\pro\MicrosoftClarityPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_TRENDS =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleTrendsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZOHO_BOOKINGS =>
                \DevOwl\RealCookieBanner\presets\pro\ZohoBookingsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZOHO_FORMS =>
                \DevOwl\RealCookieBanner\presets\pro\ZohoFormsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADD_TO_ANY =>
                \DevOwl\RealCookieBanner\presets\pro\AddToAnyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::APPLE_MUSIC =>
                \DevOwl\RealCookieBanner\presets\pro\AppleMusicPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ANCHOR_FM =>
                \DevOwl\RealCookieBanner\presets\pro\AnchorFmPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SPOTIFY =>
                \DevOwl\RealCookieBanner\presets\pro\SpotifyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::REDDIT =>
                \DevOwl\RealCookieBanner\presets\pro\RedditPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TIKTOK =>
                \DevOwl\RealCookieBanner\presets\pro\TikTokPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::BING_MAPS =>
                \DevOwl\RealCookieBanner\presets\pro\BingMapsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADD_THIS =>
                \DevOwl\RealCookieBanner\presets\pro\AddThisPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ACTIVE_CAMPAIGN_SITE_TRACKING =>
                \DevOwl\RealCookieBanner\presets\pro\ActiveCampaignSiteTrackingPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::DISCORD_WIDGET =>
                \DevOwl\RealCookieBanner\presets\pro\DiscordWidgetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MY_FONTS =>
                \DevOwl\RealCookieBanner\presets\pro\MyFontsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PROVEN_EXPERT_WIDGET =>
                \DevOwl\RealCookieBanner\presets\pro\ProvenExpertWidgetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::USERLIKE =>
                \DevOwl\RealCookieBanner\presets\pro\UserlikePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MOUSEFLOW =>
                \DevOwl\RealCookieBanner\presets\pro\MouseflowPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MONSTERINSIGHTS =>
                \DevOwl\RealCookieBanner\presets\pro\MonsterInsightsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GA_GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\GAGoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GA_GOOGLE_ANALYTICS_4 =>
                \DevOwl\RealCookieBanner\presets\pro\GAGoogleAnalytics4Preset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EXACT_METRICS =>
                \DevOwl\RealCookieBanner\presets\pro\ExactMetricsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ANALYTIFY =>
                \DevOwl\RealCookieBanner\presets\pro\AnalytifyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE_GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\WooCommerceGoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE_GOOGLE_ANALYTICS_4 =>
                \DevOwl\RealCookieBanner\presets\pro\WooCommerceGoogleAnalytics4Preset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_FOR_WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookForWooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MATOMO_PLUGIN =>
                \DevOwl\RealCookieBanner\presets\pro\MatomoPluginPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::STRIPE =>
                \DevOwl\RealCookieBanner\presets\pro\StripePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE_GATEWAY_STRIPE =>
                \DevOwl\RealCookieBanner\presets\pro\WooCommerceGatewayStripePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MAILCHIMP_FOR_WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\MailchimpForWooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::LUCKY_ORANGE =>
                \DevOwl\RealCookieBanner\presets\pro\LuckyOrangePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CUSTOM_FACEBOOK_FEED =>
                \DevOwl\RealCookieBanner\presets\pro\CustomFacebookFeedPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CUSTOM_TWITTER_FEED =>
                \DevOwl\RealCookieBanner\presets\pro\CustomTwitterFeedPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FEEDS_FOR_YOUTUBE =>
                \DevOwl\RealCookieBanner\presets\pro\FeedsForYoutubePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MAILERLITE =>
                \DevOwl\RealCookieBanner\presets\pro\MailerLitePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CLEANTALK_SPAM_PROTECT =>
                \DevOwl\RealCookieBanner\presets\pro\CleanTalkSpamProtectPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDFENCE =>
                \DevOwl\RealCookieBanner\presets\pro\WordfencePreset::class
        ]);
    }
    /**
     * Create PRO-specific blocker presets.
     *
     * @param array $result
     */
    public function createProBlockerPresets($result) {
        return \array_merge($result, [
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PINTEREST =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\PinterestPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::IMGUR =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ImgurPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_TRANSLATE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleTranslatePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleRecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADOBE_TYPEKIT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AdobeTypekitPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_MAPS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleMapsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TWITTER_TWEET =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\TwitterTweetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FLICKR =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FlickrPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::INSTAGRAM_POST =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\InstagramPostPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_PAGE_PLUGIN =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPagePluginPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_SHARE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookSharePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_LIKE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookLikePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_POST =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPostPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CONTACT_FORM_7_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ContactForm7RecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FORM_MAKER_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FormMakerRecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CALDERA_FORMS_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\CalderaFormsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::NINJA_FORMS_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\NinjaFormsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WPFORMS_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\WPFormsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FORMIDABLE_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FormidablePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::VG_WORT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\VGWortPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_TRENDS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleTrendsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZOHO_BOOKINGS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ZohoBookingsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZOHO_FORMS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ZohoFormsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADD_TO_ANY =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AddToAnyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::APPLE_MUSIC =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AppleMusicPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ANCHOR_FM =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AnchorFmPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SPOTIFY =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\SpotifyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::REDDIT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\RedditPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TIKTOK =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\TikTokPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::BING_MAPS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\BingMapsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADD_THIS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AddThisPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ACTIVE_CAMPAIGN_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ActiveCampaignFormPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::DISCORD_WIDGET =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\DiscordWidgetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_PIXEL =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPixelPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MY_FONTS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MyFontsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PROVEN_EXPERT_WIDGET =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ProvenExpertWidgetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MONSTERINSIGHTS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MonsterInsightsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GA_GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GAGoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EXACT_METRICS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ExactMetricsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ANALYTIFY =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AnalytifyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE_GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\WooCommerceGoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_FOR_WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookForWooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MATOMO_PLUGIN =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MatomoPluginPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MAILCHIMP_FOR_WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MailchimpForWooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CLEVERREACH_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\CleverReachRecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CUSTOM_FACEBOOK_FEED =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\CustomFacebookFeedPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CUSTOM_TWITTER_FEED =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\CustomTwitterFeedPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FEEDS_FOR_YOUTUBE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FeedsForYoutubePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MAILERLITE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MailerLitePreset::class
        ]);
    }
}
