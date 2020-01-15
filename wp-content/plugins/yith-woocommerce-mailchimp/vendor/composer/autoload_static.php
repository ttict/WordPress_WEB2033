<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbe0c8e29d70afe26fb6c668e83543563
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DrewM\\MailChimp\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DrewM\\MailChimp\\' => 
        array (
            0 => __DIR__ . '/..' . '/drewm/mailchimp-api/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbe0c8e29d70afe26fb6c668e83543563::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbe0c8e29d70afe26fb6c668e83543563::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}