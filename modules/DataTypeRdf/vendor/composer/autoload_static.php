<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit107ad3a1fe8ea4e69b7875d68f8f2083
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'cweagans\\Composer\\' => 18,
        ),
        'O' => 
        array (
            'OomphInc\\ComposerInstallersExtender\\' => 36,
        ),
        'D' => 
        array (
            'DataTypeRdf\\' => 12,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'cweagans\\Composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/cweagans/composer-patches/src',
        ),
        'OomphInc\\ComposerInstallersExtender\\' => 
        array (
            0 => __DIR__ . '/..' . '/oomphinc/composer-installers-extender/src',
        ),
        'DataTypeRdf\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit107ad3a1fe8ea4e69b7875d68f8f2083::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit107ad3a1fe8ea4e69b7875d68f8f2083::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit107ad3a1fe8ea4e69b7875d68f8f2083::$classMap;

        }, null, ClassLoader::class);
    }
}
