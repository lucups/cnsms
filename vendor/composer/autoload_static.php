<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6624e50616bc7c47f52de1dfe5dcaad6
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Lucups\\Sms\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Lucups\\Sms\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6624e50616bc7c47f52de1dfe5dcaad6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6624e50616bc7c47f52de1dfe5dcaad6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6624e50616bc7c47f52de1dfe5dcaad6::$classMap;

        }, null, ClassLoader::class);
    }
}
