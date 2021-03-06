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
            'name' => 'devowl-wp/deliver-anonymous-asset'
        ],
        'versions' => [
            'devowl-wp/deliver-anonymous-asset' => [
                'pretty_version' => 'dev-master',
                'version' => 'dev-master',
                'aliases' => [],
                'reference' => 'f3e03df163ebd3eb41e64acc0852e495fdccbfb8'
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
