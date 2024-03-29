<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit58c045181513e74ba1c54d56f403ea36
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Common\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Common\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit58c045181513e74ba1c54d56f403ea36::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit58c045181513e74ba1c54d56f403ea36::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit58c045181513e74ba1c54d56f403ea36::$classMap;

        }, null, ClassLoader::class);
    }
}
