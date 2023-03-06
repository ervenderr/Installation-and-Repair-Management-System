<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit632d18779b37fa6fd2a4b6479b97402f
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit632d18779b37fa6fd2a4b6479b97402f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit632d18779b37fa6fd2a4b6479b97402f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit632d18779b37fa6fd2a4b6479b97402f::$classMap;

        }, null, ClassLoader::class);
    }
}