<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit17d0beb6dd739b1b07180d06714e4a2e
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'JamesHeinrich\\GetID3\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'JamesHeinrich\\GetID3\\' => 
        array (
            0 => __DIR__ . '/..' . '/james-heinrich/getid3/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit17d0beb6dd739b1b07180d06714e4a2e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit17d0beb6dd739b1b07180d06714e4a2e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit17d0beb6dd739b1b07180d06714e4a2e::$classMap;

        }, null, ClassLoader::class);
    }
}