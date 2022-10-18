<?php

use PhpCsFixer\Finder;

$finder = Finder::create()->in(
    [
        __DIR__.'/src',
        __DIR__.'/config',
        __DIR__.'/public/app/mu-plugins',
        __DIR__.'/public/app/themes/site-default',
    ]
);

return (new \PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@PSR12' => true,
            '@Symfony' => true,
            '@Symfony:risky' => true,
            'yoda_style' => false,
            'multiline_whitespace_before_semicolons' => false,
            'array_syntax' => ['syntax' => 'short'],
            'modernize_strpos' => true,
            'native_function_invocation' => true,
            'class_attributes_separation' => true,
        ]
    )
    ->setFinder($finder);
