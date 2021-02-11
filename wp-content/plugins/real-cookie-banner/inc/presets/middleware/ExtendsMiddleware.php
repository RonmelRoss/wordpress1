<?php

namespace DevOwl\RealCookieBanner\presets\middleware;

use DevOwl\RealCookieBanner\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Middleware to enable `attributes.extends` in cookie and content blocker presets.
 */
class ExtendsMiddleware {
    /**
     * `attributes` can contain a magic key `extends` with a class name. Let's extend
     * from that attributes.
     *
     * @param array $preset
     */
    public function middleware(&$preset) {
        if (isset($preset['attributes']) && isset($preset['attributes']['extends'])) {
            $clazz = $preset['attributes']['extends'];
            /**
             * Instance.
             *
             * @var AbstractCookiePreset
             */
            $instance = new $clazz();
            $preset['attributes'] = \array_merge($instance->common()['attributes'], $preset['attributes']);
            unset($preset['attributes']['extends']);
            // Allow extending single properties (useful for arrays)
            foreach ($preset['attributes'] as $extendsKey => $extendsValue) {
                if (\DevOwl\RealCookieBanner\Utils::startsWith($extendsKey, 'extends')) {
                    foreach ($preset['attributes'] as $key => $value) {
                        if ($extendsKey === \sprintf('extends%sStart', \ucfirst($key))) {
                            $preset['attributes'][$key] = \array_merge($extendsValue, $value);
                        } elseif ($extendsKey === \sprintf('extends%sEnd', \ucfirst($key))) {
                            $preset['attributes'][$key] = \array_merge($value, $extendsValue);
                        } else {
                            continue;
                        }
                        unset($preset['attributes'][$extendsKey]);
                    }
                }
            }
        }
        return $preset;
    }
}
