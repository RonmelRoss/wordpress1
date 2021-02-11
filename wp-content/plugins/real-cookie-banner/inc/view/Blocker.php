<?php

namespace DevOwl\RealCookieBanner\view;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\settings\Blocker as SettingsBlocker;
use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\Utils;
use WP_Post;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Block common HTML tags!
 */
class Blocker {
    use UtilsProvider;
    const BUTTON_CLICKED_IDENTIFIER = 'unblock';
    const REPLACE_TAGS = ['script', 'link', 'iframe', \DevOwl\RealCookieBanner\view\SrcSetBlocker::HTML_TAG_IMG];
    const REPLACE_ATTRIBUTES = ['href', \DevOwl\RealCookieBanner\view\SrcSetBlocker::HTML_ATTRIBUTE_SRC];
    /**
     * `<div>` elements are expensive in Regexp cause there a lot of them, let's assume only a
     * set of attributes to get a match. For example, WP Rockets' lazy loading technology modifies
     * iFrames and YouTube embeds.
     *
     * @see https://git.io/JLQSy
     */
    const REPLACE_TAGS_DIV = ['div'];
    const REPLACE_ATTRIBUTES_DIV = [
        // [Plugin Comp] WP Rocket
        'data-src',
        'data-lazy-src',
        // [Theme Comp] FloThemes
        'data-flo-video-embed-embed-code'
    ];
    /**
     * A set of HTML tags => attribute names which should always prefix with `consent-original-`.
     */
    const REPLACE_ALWAYS_ATTRIBUTES = ['iframe' => ['sandbox']];
    /**
     * In some cases we need to keep the attributes as original instead of prefix it with `consent-original-`.
     * Keep in mind, that no external data should be loaded if the attribute is set!
     */
    const KEEP_ALWAYS_ATTRIBUTES = [
        // [Theme Comp] FloThemes
        'data-flo-video-embed-embed-code'
    ];
    /**
     * If a given class is given, set the visual parent. This is needed for some page builder
     * and theme compatibilities.
     */
    const SET_VISUAL_PARENT_IF_CLASS = [
        // [Theme Comp] FloThemes
        'flo-video-embed__screen' => 2
    ];
    const OB_START_PLUGINS_LOADED_PRIORITY = (\PHP_INT_MAX - 1) * -1;
    /**
     * Force to output the needed computing time at the end of the page for debug purposes.
     */
    const FORCE_TIME_COMMENT_QUERY_ARG = 'rcb-calc-time';
    /**
     * Match a string of attributes to an array.
     *
     * Available matches:
     *      $match[0] => Full string
     *      $match[1] => Attribute name
     *      $match[2] => Attribute value
     *
     * @see https://regex101.com/r/yz3x6C/2/
     * @see https://developer.wordpress.org/reference/functions/get_shortcode_atts_regex/
     * @deprecated Use `Utils::parseHtmlAttributes` instead
     */
    const ATTRIBUTES_REGEXP = '/([\\w-]+)\\s*=\\s*"([^"]*)"(?:\\s|$)|([\\w-]+)\\s*=\\s*\'([^\']*)\'(?:\\s|$)|([\\w-]+)\\s*=\\s*([^\\s\'"]+)(?:\\s|$)|"([^"]*)"(?:\\s|$)|\'([^\']*)\'(?:\\s|$)|(\\S+)(?:\\s|$)/ms';
    // Also ported to `applyContentBlocker/listenOptIn.tsx`
    const HTML_ATTRIBUTE_CAPTURE_PREFIX = 'consent-original';
    const HTML_ATTRIBUTE_BLOCKER_ID = 'consent-id';
    const HTML_ATTRIBUTE_COOKIE_IDS = 'consent-required';
    const HTML_ATTRIBUTE_VISUAL_PARENT = 'consent-visual-use-parent';
    private $cacheResolvedBlockers = null;
    private $obStatus = \true;
    /**
     * C'tor.
     *
     * @codeCoverageIgnore
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Localize available content blockers for frontend.
     */
    public function localize() {
        $output = [];
        $blockers = \DevOwl\RealCookieBanner\settings\Blocker::getInstance()->getOrdered();
        foreach ($blockers as $blocker) {
            $output[] = \array_merge(
                ['id' => $blocker->ID, 'name' => $blocker->post_title, 'description' => $blocker->post_content],
                $blocker->metas
            );
        }
        return $output;
    }
    /**
     * Apply the content blocker attributes to the output buffer when it is enabled.
     */
    public function registerOutputBuffer() {
        if ($this->isEnabled() && !\DevOwl\RealCookieBanner\Utils::isPageBuilderFrontend()) {
            \ob_start([$this, 'ob_start']);
        }
    }
    /**
     * Check if a given tag, link attribute and link is blocked.
     *
     * @param WP_Post[] $blockers
     * @param string $tag
     * @param string $linkAttribute
     * @param string $link
     * @param array $attributes
     */
    public function isBlocked($blockers, $tag, $linkAttribute, $link, $attributes) {
        $isBlocked = \false;
        // Find all public content blockers and check URL
        foreach ($blockers as $blocker) {
            $cookies = $blocker->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES];
            // Iterate all wildcard URLs
            foreach ($blocker->regexp['wildcard'] as $regex) {
                if (\preg_match($regex, $link)) {
                    // This link is definitely blocked by configuration
                    $isBlocked = ['blocker' => $blocker, 'cookies' => $cookies];
                    break 2;
                }
            }
        }
        // Allow to skip content blocker by HTML attribute
        if (
            $isBlocked !== \false &&
            \DevOwl\RealCookieBanner\view\SkipBlockerTag::getInstance()->isSkipped($attributes)
        ) {
            $isBlocked = \false;
        }
        /**
         * Check if a given tag, link attribute and link is blocked.
         *
         * @hook RCB/Blocker/IsBlocked
         * @param {false|array} $isBlocked
         * @param {WP_Post[]} $blockers
         * @param {string} $tag
         * @param {string} $linkAttribute
         * @param {string} $link
         * @param {array} $attributes
         * @return {false|array} Return false, or an array ['blocker] => WP_Post blocker instance, ['cookies'] => of cookie ids which need to be consent to so the link is unblocked
         */
        return apply_filters('RCB/Blocker/IsBlocked', $isBlocked, $blockers, $tag, $linkAttribute, $link, $attributes);
    }
    /**
     * Event for ob_start.
     *
     * @param string $response
     */
    public function ob_start($response) {
        if (!$this->obStatus) {
            return $response;
        }
        $start = \microtime(\true);
        // Measure replace time
        /**
         * Block content in a given HTML string. This is a Consent API filter and can be consumed
         * by third-party plugin and theme developers. See example for usage.
         *
         * @hook Consent/Block/HTML
         * @param {string} $html
         * @return {string}
         * @example <caption>Block content of a given HTML string</caption>
         * $output = apply_filters('Consent/Block/HTML', '<iframe src="https://player.vimeo.com/..." />');
         */
        $newResponse = apply_filters('Consent/Block/HTML', $response);
        $time_elapsed_secs = \microtime(\true) - $start;
        $htmlEndComment = '<!--rcb-cb:' . \json_encode(['replace-time' => $time_elapsed_secs]) . '-->';
        return ($newResponse === null ? $response : $newResponse) .
            ((\DevOwl\RealCookieBanner\Utils::currentContentTypeIs('text/html') &&
                (is_page() || is_page() || is_archive() || is_category())) ||
            isset($_GET[self::FORCE_TIME_COMMENT_QUERY_ARG])
                ? $htmlEndComment
                : '');
    }
    /**
     * Allows to suspend the output buffer modification.
     *
     * @param boolean $status
     */
    public function setOutputBufferStatus($status) {
        $this->obStatus = $status;
        if ($status === \false) {
            // Suppress all other output buffers as they should not be handle any data here
            // phpcs:disable
            while (@\ob_get_flush()) {
            }
            // phpcs:enable
        }
    }
    /**
     * Apply content blockers to a given HTML string. If you want to use this functionality in your
     * plugin, please use the filter `Consent/Block/HTML` instead!
     *
     * @param string $html
     */
    public function replace($html) {
        // Common HTML tags
        $html = \preg_replace_callback(
            self::createRegexp(self::REPLACE_TAGS, self::REPLACE_ATTRIBUTES),
            [$this, 'replaceMatcherCallback'],
            $html
        );
        // Special `div`'s
        $html = \preg_replace_callback(
            self::createRegexp(self::REPLACE_TAGS_DIV, self::REPLACE_ATTRIBUTES_DIV),
            [$this, 'replaceMatcherCallback'],
            $html
        );
        // Inline Scripts
        $html = \preg_replace_callback(
            \DevOwl\RealCookieBanner\view\ScriptInlineBlocker::SCRIPT_INLINE_REGEXP,
            [\DevOwl\RealCookieBanner\view\ScriptInlineBlocker::getInstance(), 'replaceMatcherCallback'],
            $html
        );
        // Inline Styles
        $html = \preg_replace_callback(
            \DevOwl\RealCookieBanner\view\StyleInlineBlocker::STYLE_INLINE_REGEXP,
            [\DevOwl\RealCookieBanner\view\StyleInlineBlocker::getInstance(), 'replaceMatcherCallback'],
            $html
        );
        // Custom Element Blocker
        foreach ($this->getResolvedBlockers() as $blocker) {
            if (\is_array($blocker->customElementBlocker)) {
                foreach ($blocker->customElementBlocker as $customElementBlocker) {
                    $html = $customElementBlocker->replace($html);
                }
            }
        }
        /**
         * Modify HTML content for content blockers. This is called directly after the core
         * content blocker has done its job for common HTML tags (iframe, scripts, ... ) and
         * inline scripts.
         *
         * @hook RCB/Blocker/HTML
         * @param {string} $html
         * @return {string}
         */
        return apply_filters('RCB/Blocker/HTML', $html);
    }
    /**
     * Callback for `preg_replace_callback` with a given `createRegexp` regexp.
     *
     * @param mixed $m
     */
    public function replaceMatcherCallback($m) {
        list($beforeLinkAttribute, $tag, $linkAttribute, $link, $afterLink, $attributes) = self::prepareMatch($m);
        // Do not modify escaped data as they appear mostly in JSON CDATA - we do not modify behavior of other plugins and themes ;-)
        if (\strpos($link, '\\') !== \false || empty(\trim($link)) || self::isAlreadyBlocked($attributes)) {
            return $m[0];
        }
        $blockers = $this->getResolvedBlockers();
        $isBlocked = $this->isBlocked($blockers, $tag, $linkAttribute, $link, $attributes);
        if (!\is_array($isBlocked)) {
            return $m[0];
        }
        // Prepare new attributes
        $this->prepareVisualParent($tag, $attributes);
        $newLinkAttribute = self::HTML_ATTRIBUTE_CAPTURE_PREFIX . '-' . $linkAttribute;
        $this->prepareNewLinkElement($tag, $attributes, $linkAttribute, $newLinkAttribute, $link);
        $attributes[self::HTML_ATTRIBUTE_COOKIE_IDS] = \join(',', $isBlocked['cookies']);
        $attributes[self::HTML_ATTRIBUTE_BLOCKER_ID] = $isBlocked['blocker']->ID;
        $this->replaceAlwaysAttributes($tag, $attributes);
        /**
         * A tag got blocked, e. g. `iframe`. We can now modify the attributes again to add an additional attribute to
         * the blocked content. This can be especially useful if you want to block additional attributes like `srcset`.
         * Do not forget to hook into the frontend and transform the modified attributes!
         *
         * @hook RCB/Blocker/HTMLAttributes
         * @param {array} $attributes
         * @param {array} $isBlocked [blocker] => WP_Post blocker instance, [cookies] => List of needed cookie ids
         * @param {WP_Post[]} $blockers
         * @param {string} $tag
         * @param {string} $newLinkAttribute
         * @param {string} $linkAttribute
         * @param {string} $link
         * @return {array}
         */
        $attributes = apply_filters(
            'RCB/Blocker/HTMLAttributes',
            $attributes,
            $isBlocked,
            $blockers,
            $tag,
            $newLinkAttribute,
            $linkAttribute,
            $link
        );
        return \sprintf(
            '%1$s %2$s %3$s',
            $beforeLinkAttribute,
            \DevOwl\RealCookieBanner\Utils::htmlAttributes($attributes),
            $afterLink
        );
    }
    /**
     * Prepare visual parent depending on class.
     *
     * @param string $tag
     * @param array $attributes
     * @param string $linkAttribute
     * @param string $newLinkAttribute
     * @param string $link
     */
    protected function prepareNewLinkElement($tag, &$attributes, $linkAttribute, $newLinkAttribute, $link) {
        /**
         * In some cases we need to keep the attributes as original instead of prefix it with `consent-original-`.
         * Keep in mind, that no external data should be loaded if the attribute is set!
         *
         * @hook RCB/Blocker/KeepAttributes
         * @param {string[]} $keepAttributes
         * @param {string} $tag
         * @param {array} $attributes
         * @param {string} $linkAttribute
         * @param {string} $link
         * @return {string[]}
         * @since 1.5.0
         */
        $keepAttributes = apply_filters(
            'RCB/Blocker/KeepAttributes',
            self::KEEP_ALWAYS_ATTRIBUTES,
            $tag,
            $attributes,
            $linkAttribute,
            $link
        );
        if (\in_array($linkAttribute, $keepAttributes, \true)) {
            $attributes[$linkAttribute] = $link;
        } else {
            $attributes[$newLinkAttribute] = $link;
        }
    }
    /**
     * Prepare visual parent depending on class.
     *
     * @param string $tag
     * @param array $attributes
     */
    protected function prepareVisualParent($tag, &$attributes) {
        $useVisualParent = \false;
        if (isset($attributes['class'])) {
            $classes = \explode(' ', $attributes['class']);
            foreach ($classes as $class) {
                $class = \strtolower($class);
                foreach (self::SET_VISUAL_PARENT_IF_CLASS as $key => $visualParent) {
                    if ($class === $key) {
                        $useVisualParent = $visualParent;
                        break 2;
                    }
                }
            }
        }
        /**
         * A tag got blocked, e. g. `iframe`. We can now determine the "Visual Parent". The visual parent is the
         * closest parent where the content blocker should be placed to. The visual parent can be configured as follow:
         *
         * ```
         * false = Use original element
         * true = Use parent element
         * number = Go upwards x element (parentElement)
         * string = Go upwards until parentElement matches a selector
         * ```
         *
         * @hook RCB/Blocker/VisualParent
         * @param {boolean|string|number} $useVisualParent
         * @param {string} $tag
         * @param {array} $attributes
         * @return {boolean|string|number}
         * @since 1.5.0
         */
        $useVisualParent = apply_filters('RCB/Blocker/VisualParent', $useVisualParent, $tag, $attributes);
        if ($useVisualParent !== \false) {
            $attributes[self::HTML_ATTRIBUTE_VISUAL_PARENT] = $useVisualParent;
        }
    }
    /**
     * Replace all known attributes which should be always replaced.
     *
     * @param string $tag
     * @param array $attributes
     */
    protected function replaceAlwaysAttributes($tag, &$attributes) {
        if (isset(self::REPLACE_ALWAYS_ATTRIBUTES[$tag])) {
            foreach (self::REPLACE_ALWAYS_ATTRIBUTES[$tag] as $attr) {
                if (isset($attributes[$attr])) {
                    $newAttrName = \sprintf('%s-%s', self::HTML_ATTRIBUTE_CAPTURE_PREFIX, $attr);
                    $attributes[$newAttrName] = $attributes[$attr];
                    unset($attributes[$attr]);
                }
            }
        }
    }
    /**
     * Get all available blocker with additional extended attributes in WP_Post instance
     * like prepared regexp for contains and wildcards.
     *
     * @return WP_Post[]
     */
    public function getResolvedBlockers() {
        if ($this->cacheResolvedBlockers !== null) {
            return $this->cacheResolvedBlockers;
        }
        $blockers = \DevOwl\RealCookieBanner\settings\Blocker::getInstance()->getOrdered();
        $wildcardCb = [\DevOwl\RealCookieBanner\Utils::class, 'createRegxpPatternFromWildcardedName'];
        foreach ($blockers as &$blocker) {
            // Ignore blockers with no connected cookies
            if (\count($blocker->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES]) === 0) {
                continue;
            }
            // Read hosts / URLs configuration and transform to valid regexp
            $hosts = $blocker->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS];
            // Filter out custom element expressions
            $blocker->customElementBlocker = [];
            foreach ($hosts as $idx => $line) {
                $customElementBlocker = \DevOwl\RealCookieBanner\view\CustomElementBlocker::probableCreateInstance(
                    $line,
                    $blocker
                );
                if ($customElementBlocker !== \false) {
                    unset($hosts[$idx]);
                    $blocker->customElementBlocker[] = $customElementBlocker;
                }
            }
            $blocker->regexp = ['wildcard' => \array_map($wildcardCb, $hosts)];
            // Force to wildcard all hosts look like a `contains`
            foreach ($hosts as $idx => $host) {
                $hosts[$idx] = '*' . $host . '*';
            }
            $blocker->regexp['contains'] = \array_map($wildcardCb, $hosts);
        }
        $this->cacheResolvedBlockers = $blockers;
        return $blockers;
    }
    /**
     * Check if content blocker is enabled on the current request.
     */
    protected function isEnabled() {
        return \DevOwl\RealCookieBanner\Utils::isFrontend() &&
            \DevOwl\RealCookieBanner\settings\General::getInstance()->isBannerActive() &&
            \DevOwl\RealCookieBanner\settings\General::getInstance()->isBlockerActive();
    }
    /**
     * Check if a given set of HTML attributes already contains the "blocked"-attribute
     * so we can skip duplicate blockages.
     *
     * @param string[] $attributes
     */
    public static function isAlreadyBlocked($attributes) {
        return isset($attributes[self::HTML_ATTRIBUTE_BLOCKER_ID]);
    }
    /**
     * Prepare the result match of a `createRegexp` regexp.
     *
     * @param array $m
     */
    public static function prepareMatch($m) {
        // Prepare data
        $beforeLinkAttribute = $m[1];
        $tag = $m[2];
        $linkAttribute = $m[3];
        $link = $m[5];
        $afterLink = $m[6];
        // Prepare all attributes as array (unfortunately not available from regexp due to back-reference usage...)
        $beforeLinkAttribute = \explode(' ', $beforeLinkAttribute . ' ', 2);
        $withoutClosingTagChars = \rtrim($afterLink, '/>');
        $afterLink = \substr($afterLink, (\strlen($afterLink) - \strlen($withoutClosingTagChars)) * -1);
        $attributes = \DevOwl\RealCookieBanner\Utils::parseHtmlAttributes(
            $beforeLinkAttribute[1] . ' ' . \ltrim($withoutClosingTagChars, '"\'')
        );
        $beforeLinkAttribute = $beforeLinkAttribute[0];
        return [$beforeLinkAttribute, $tag, $linkAttribute, $link, $afterLink, $attributes];
    }
    /**
     * Create regular expression to catch multiple tags and attributes.
     *
     * Available matches:
     *      $match[0] => Full string
     *      $match[1] => All content before the link attribute
     *      $match[2] => Used tag
     *      $match[3] => Used link attribute
     *      $match[4] => Used quote for link attribute
     *      $match[5] => Link
     *      $match[6] => All content after the link
     *
     * @param string[] $searchTags
     * @param string[] $searchAttributes
     * @see https://regex101.com/r/cQ9ILs/9
     */
    public static function createRegexp($searchTags, $searchAttributes) {
        return \sprintf(
            '/(<(%s)\\s[^>]*)(%s)=([\\"\']??)([^\\4]*)(\\4[^>]*>)/siU',
            \join('|', $searchTags),
            \join('|', $searchAttributes)
        );
    }
    /**
     * New instance.
     *
     * @codeCoverageIgnore
     */
    public static function instance() {
        return new \DevOwl\RealCookieBanner\view\Blocker();
    }
}
