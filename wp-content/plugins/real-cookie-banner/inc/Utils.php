<?php

namespace DevOwl\RealCookieBanner;

use WP_Rewrite;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Utility helpers.
 */
class Utils {
    const TEMP_REGEX_AVOID_UNMASK = 'PLEACE_REPLACE_ME_AGAIN';
    /**
     * nip.io
     */
    const HOST_TYPE_MAIN = 'main';
    /**
     * .nip.io
     */
    const HOST_TYPE_MAIN_WITH_ALL_SUBDOMAINS = 'main+subdomains';
    /**
     * feat.nip.io
     */
    const HOST_TYPE_CURRENT = 'current';
    /**
     * https://feat.nip.io
     */
    const HOST_TYPE_CURRENT_PROTOCOL = 'current+protocol';
    /**
     * .feat.nip.io
     */
    const HOST_TYPE_CURRENT_WITH_ALL_SUBDOMAINS = 'current+subdomains';
    const PREINSTALLED_ENV_IONOS = 'ionos';
    /**
     * Check if the current installation is a preinstalled environment.
     *
     * @return string|false
     */
    public static function isPreinstalledEnvironment() {
        // IONOS
        $mu_plugins = get_mu_plugins();
        if (isset($mu_plugins['ionos-assistant.php'])) {
            return self::PREINSTALLED_ENV_IONOS;
        }
        return \false;
    }
    /**
     * Get the list of active plugins in a map: File => Name. This is needed for the config and the
     * notice for `skip-if-active` attribute in cookie opt-in codes.
     *
     * @param boolean $includeSlugs
     */
    public static function getActivePluginsMap($includeSlugs = \true) {
        $result = [];
        $plugins = get_option('active_plugins');
        foreach ($plugins as $pluginFile) {
            $result[$pluginFile] = get_plugin_data(\constant('WP_PLUGIN_DIR') . '/' . $pluginFile)['Name'];
            if ($includeSlugs) {
                $slug = \explode('/', $pluginFile)[0];
                $result[$slug] = $result[$pluginFile];
            }
        }
        return $result;
    }
    /**
     * Checks if any of the given plugins is active. It supports also slugs.
     *
     * @param string|string[] $plugins
     */
    public static function anyPluginActive($plugins) {
        $plugins = \is_array($plugins) ? $plugins : \explode(',', $plugins);
        return \in_array(\true, \array_map([self::class, 'isPluginActive'], $plugins), \true);
    }
    /**
     * Check if a single plugin is active. It supports also slugs.
     *
     * @param string $plugin
     */
    public static function isPluginActive($plugin) {
        if (is_plugin_active($plugin)) {
            return \true;
        }
        $activePluginSlugs = [];
        foreach (get_option('active_plugins') as $activePlugin) {
            $activePluginSlugs[] = \explode('/', $activePlugin)[0];
        }
        return \in_array($plugin, $activePluginSlugs, \true);
    }
    /**
     * Support samesite cookie flag in both php 7.2 (current production) and php >= 7.3 (when we get there)
     * From: https://github.com/GoogleChromeLabs/samesite-examples/blob/master/php.md and https://stackoverflow.com/a/46971326/2308553
     *
     * @see https://stackoverflow.com/a/59654832/5506547
     * @see https://developer.mozilla.org/de/docs/Web/HTTP/Headers/Set-Cookie/SameSite
     * @param [type] $name
     * @param [type] $value
     * @param [type] $expire
     * @param [type] $path
     * @param [type] $domain
     * @param [type] $secure
     * @param [type] $httponly
     * @param [type] $samesite
     */
    public static function setCookie(
        $name,
        $value = '',
        $expire = 0,
        $path = '',
        $domain = '',
        $secure = \false,
        $httponly = \false,
        $samesite = ''
    ) {
        // Avoid warning : A cookie associated with a resource at URL was set with `SameSite=None` but without `Secure`.
        // It has been blocked, as Chrome now only delivers cookies marked `SameSite=None` if they are also marked `Secure`.
        // You can review cookies in developer tools under Application>Storage>Cookies and see more details at https://www.chromestatus.com/feature/5633521622188032.
        // See also https://developer.mozilla.org/de/docs/Web/HTTP/Headers/Set-Cookie/SameSite
        $defaultSameSite = 'Strict';
        // supported in all browsers without any security warnings
        $useSameSite = empty($samesite) ? $defaultSameSite : $samesite;
        $useSameSite = \strtolower($useSameSite) === 'none' && !$secure ? $defaultSameSite : $useSameSite;
        if (\PHP_VERSION_ID < 70300) {
            return \setcookie($name, $value, $expire, "{$path}; samesite={$useSameSite}", $domain, $secure, $httponly);
        } else {
            return \setcookie($name, $value, [
                'expires' => $expire,
                'path' => $path,
                'domain' => $domain,
                'samesite' => $useSameSite,
                'secure' => $secure,
                'httponly' => $httponly
            ]);
        }
    }
    /**
     * Hash a passed string. It uses PHP `hash` and md5 as fallback as `hash` is not
     * available in all environments.
     *
     * @param string $data
     */
    public static function hash($data) {
        $data = \constant('NONCE_SALT') . $data;
        if (\function_exists('hash')) {
            return \hash('sha256', $data);
        } else {
            return \str_repeat('0', 32) . \md5($data);
        }
    }
    /**
     * Get a host URL for technical cookie definitions.
     *
     * @param string $type See class constants
     * @see https://stackoverflow.com/a/6768831/5506547
     */
    public static function host($type) {
        $actual_link =
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') .
            "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $parsed = \parse_url($actual_link);
        $scheme = $parsed['scheme'];
        $host = $parsed['host'];
        switch ($type) {
            case self::HOST_TYPE_MAIN:
                return self::giveHost($host);
            case self::HOST_TYPE_MAIN_WITH_ALL_SUBDOMAINS:
                return '.' . self::giveHost($host);
            case self::HOST_TYPE_CURRENT:
                return $host;
            case self::HOST_TYPE_CURRENT_PROTOCOL:
                return $scheme . '://' . $host;
            case self::HOST_TYPE_CURRENT_WITH_ALL_SUBDOMAINS:
                return '.' . $host;
            default:
                return '';
        }
    }
    /**
     * Remove all subdomains from host string.
     *
     * @param string $host_with_subdomain
     * @see https://stackoverflow.com/a/21809669/5506547
     */
    public static function giveHost($host_with_subdomain) {
        $array = \explode('.', $host_with_subdomain);
        $domain = \array_key_exists(\count($array) - 2, $array) ? $array[\count($array) - 2] : '';
        return (empty($domain) ? '' : $domain . '.') . $array[\count($array) - 1];
    }
    /**
     * Check if a string starts with a given needle.
     *
     * @param string $haystack The string to search in
     * @param string $needle The starting string
     * @see https://stackoverflow.com/a/834355/5506547
     */
    public static function startsWith($haystack, $needle) {
        $length = \strlen($needle);
        return \substr($haystack, 0, $length) === $needle;
    }
    /**
     * Check if a string starts with a given needle.
     *
     * @param string $haystack The string to search in
     * @param string $needle The starting string
     * @see https://stackoverflow.com/a/834355/5506547
     */
    public static function endsWith($haystack, $needle) {
        $length = \strlen($needle);
        if (!$length) {
            return \true;
        }
        return \substr($haystack, -$length) === $needle;
    }
    /**
     * Create a pattern for `preg_match_all` usage. It is also ported to `createRegxpPatternFromWildcardedName.tsx`.
     *
     * @param string $name
     */
    public static function createRegxpPatternFromWildcardedName($name) {
        $name = \str_replace('*', self::TEMP_REGEX_AVOID_UNMASK, $name);
        return \sprintf('/^%s$/', \str_replace(self::TEMP_REGEX_AVOID_UNMASK, '(.*)', \preg_quote($name, '/')));
    }
    /**
     * Check if current page is frontend page of WordPress.
     */
    public static function isFrontend() {
        $isFrontend = !is_admin() && !wp_doing_cron() && !wp_doing_ajax() && !self::isRest() && !self::isCLI();
        // Beaver Builder page builder
        if ($isFrontend && isset($_GET['fl_builder'])) {
            return \false;
        }
        return $isFrontend;
    }
    /**
     * Check if current request is coming from WP CLI.
     *
     * @see https://wordpress.stackexchange.com/a/226163/83335
     */
    public static function isCLI() {
        return \defined('WP_CLI') && \constant('WP_CLI');
    }
    /**
     * Checks if the given page request is a page builder frontend. This is a continuous function
     * and needs to be extended as needed.
     */
    public static function isPageBuilderFrontend() {
        if (isset($_GET['ct_builder'])) {
            return 'oxygen';
        }
        return \false;
    }
    /**
     * Checks if the current request is a WP REST API request.
     *
     * Case #1: After WP_REST_Request initialisation
     * Case #2: Support "plain" permalink settings
     * Case #3: It can happen that WP_Rewrite is not yet initialized,
     *          so do this (wp-settings.php)
     * Case #4: URL Path begins with wp-json/ (your REST prefix)
     *          Also supports WP installations in subfolders
     *
     * @returns boolean
     * @author matzeeable
     * @see https://gist.github.com/matzeeable/dfd82239f48c2fedef25141e48c8dc30
     */
    public static function isRest() {
        if (
            (\defined('REST_REQUEST') && \constant('REST_REQUEST')) ||
            (isset($_GET['rest_route']) && \strpos(\trim($_GET['rest_route'], '\\/'), rest_get_url_prefix(), 0) === 0)
        ) {
            return \true;
        }
        // (#3)
        global $wp_rewrite;
        if ($wp_rewrite === null) {
            $wp_rewrite = new \WP_Rewrite();
        }
        // (#4)
        $rest_url = wp_parse_url(trailingslashit(rest_url()));
        $current_url = wp_parse_url(add_query_arg([]));
        return \strpos($current_url['path'], $rest_url['path'], 0) === 0;
    }
    /**
     * Parse a HTML attributes string to an associative array.
     *
     * @param string $str
     */
    public static function parseHtmlAttributes($str) {
        $attributes = shortcode_parse_atts($str);
        if (empty($attributes)) {
            $attributes = [];
        }
        // Fix single-attributes, e. g. `<input disabled />` (without value)
        foreach ($attributes as $key => $value) {
            if (\is_numeric($key)) {
                unset($attributes[$key]);
                $attributes[$value] = \true;
            }
        }
        return $attributes;
    }
    /**
     * Transform a given associate attributes array to a DOM attributes string.
     *
     * @param array $attributes
     */
    public static function htmlAttributes($attributes) {
        return \join(
            ' ',
            \array_map(function ($key) use ($attributes) {
                if (\is_bool($attributes[$key])) {
                    return $attributes[$key] ? $key : '';
                }
                return $key . '="' . esc_attr($attributes[$key]) . '"';
            }, \array_keys($attributes))
        );
    }
    /**
     * Check if current content type is the given mime type.
     *
     * @param string $mime
     * @see https://stackoverflow.com/a/22479030/5506547
     */
    public static function currentContentTypeIs($mime) {
        $headers = \headers_list();
        // get list of headers
        foreach ($headers as $header) {
            // iterate over that list of headers
            if (\stripos($header, 'Content-Type') !== \false) {
                // if the current header hasthe String "Content-Type" in it
                $headerParts = \explode(':', $header);
                // split the string, getting an array
                $headerValue = \trim($headerParts[1]);
                // take second part as value
                if (\stripos($headerValue, $mime) !== \false) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
