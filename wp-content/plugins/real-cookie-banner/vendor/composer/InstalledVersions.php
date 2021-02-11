<?php

namespace DevOwl\RealCookieBanner\Vendor\Composer;

use DevOwl\RealCookieBanner\Vendor\Composer\Semver\VersionParser;
class InstalledVersions {
    private static $installed = [
        'root' => [
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'aliases' => [],
            'reference' => 'f3e03df163ebd3eb41e64acc0852e495fdccbfb8',
            'name' => '__root__'
        ],
        'versions' => [
            '__root__' => [
                'pretty_version' => 'dev-master',
                'version' => 'dev-master',
                'aliases' => [],
                'reference' => 'f3e03df163ebd3eb41e64acc0852e495fdccbfb8'
            ],
            'devowl-wp/cache-invalidate' => [
                'pretty_version' => 'dev-develop',
                'version' => 'dev-develop',
                'aliases' => [],
                'reference' => '0dd7f8d00e2a8c208db5f50097dfe88645e1c464'
            ],
            'devowl-wp/customize' => [
                'pretty_version' => 'dev-plugin/rcb',
                'version' => 'dev-plugin/rcb',
                'aliases' => [],
                'reference' => 'b48407281b17a4a56db7afbc91361c2ce39f6b73'
            ],
            'devowl-wp/deliver-anonymous-asset' => [
                'pretty_version' => 'dev-chore/review-rtg',
                'version' => 'dev-chore/review-rtg',
                'aliases' => [],
                'reference' => 'a96bf0be335c78ed488393c6e84ee5a95fb113cc'
            ],
            'devowl-wp/freemium' => [
                'pretty_version' => 'dev-plugin/rcb',
                'version' => 'dev-plugin/rcb',
                'aliases' => [],
                'reference' => 'a9ac47c0e76a664ed8f39c61bcc1aae8567f1697'
            ],
            'devowl-wp/multilingual' => [
                'pretty_version' => 'dev-feat/4wqqym/rcb/wpml',
                'version' => 'dev-feat/4wqqym/rcb/wpml',
                'aliases' => [],
                'reference' => '8eb23fa20dc0945d21529803ac83fc08b2f29357'
            ],
            'devowl-wp/real-product-manager-wp-client' => [
                'pretty_version' => 'dev-develop',
                'version' => 'dev-develop',
                'aliases' => [],
                'reference' => 'f1e9f300f8b4194fca019f60c970ab11283bfbc7'
            ],
            'devowl-wp/real-utils' => [
                'pretty_version' => 'dev-plugin/rcb',
                'version' => 'dev-plugin/rcb',
                'aliases' => [],
                'reference' => '6322766f54f2ed70dc6865b75001fc3befb422d2'
            ],
            'devowl-wp/utils' => [
                'pretty_version' => 'dev-feat/multipackage',
                'version' => 'dev-feat/multipackage',
                'aliases' => [],
                'reference' => 'bb1d92ba33ae3925685c4cc5701938b71e37627b'
            ]
        ]
    ];
    public static function getInstalledPackages() {
        return \array_keys(self::$installed['versions']);
    }
    public static function isInstalled($packageName) {
        return isset(self::$installed['versions'][$packageName]);
    }
    public static function satisfies(
        \DevOwl\RealCookieBanner\Vendor\Composer\Semver\VersionParser $parser,
        $packageName,
        $constraint
    ) {
        $constraint = $parser->parseConstraints($constraint);
        $provided = $parser->parseConstraints(self::getVersionRanges($packageName));
        return $provided->matches($constraint);
    }
    public static function getVersionRanges($packageName) {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        $ranges = [];
        if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            $ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
        }
        if (\array_key_exists('aliases', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
        }
        if (\array_key_exists('replaced', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
        }
        if (\array_key_exists('provided', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
        }
        return \implode(' || ', $ranges);
    }
    public static function getVersion($packageName) {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['version'];
    }
    public static function getPrettyVersion($packageName) {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['pretty_version'];
    }
    public static function getReference($packageName) {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['reference'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['reference'];
    }
    public static function getRootPackage() {
        return self::$installed['root'];
    }
    public static function getRawData() {
        return self::$installed;
    }
    public static function reload($data) {
        self::$installed = $data;
    }
}
