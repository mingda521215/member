<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit70dd9e1941c8bb1e6e37340f70144ced
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit70dd9e1941c8bb1e6e37340f70144ced::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit70dd9e1941c8bb1e6e37340f70144ced::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
