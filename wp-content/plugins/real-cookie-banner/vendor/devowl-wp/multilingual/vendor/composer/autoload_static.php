<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit936b195066e317121ca12fe828c26681 {
    public static $prefixLengthsPsr4 = [
        'D' => [
            'DevOwl\\Multilingual\\Test\\' => 25,
            'DevOwl\\Multilingual\\' => 20
        ]
    ];

    public static $prefixDirsPsr4 = [
        'DevOwl\\Multilingual\\Test\\' => [
            0 => __DIR__ . '/../..' . '/test/phpunit'
        ],
        'DevOwl\\Multilingual\\' => [
            0 => __DIR__ . '/../..' . '/src'
        ]
    ];

    public static $classMap = [
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php'
    ];

    public static function getInitializer(ClassLoader $loader) {
        return \Closure::bind(
            function () use ($loader) {
                $loader->prefixLengthsPsr4 = ComposerStaticInit936b195066e317121ca12fe828c26681::$prefixLengthsPsr4;
                $loader->prefixDirsPsr4 = ComposerStaticInit936b195066e317121ca12fe828c26681::$prefixDirsPsr4;
                $loader->classMap = ComposerStaticInit936b195066e317121ca12fe828c26681::$classMap;
            },
            null,
            ClassLoader::class
        );
    }
}
