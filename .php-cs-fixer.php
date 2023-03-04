<?php

use PhpCsFixer\{Config, Finder};

$finder = Finder::create()->in(
    [
        __DIR__.'/src',
        __DIR__.'/tests',
    ]
);

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@PSR12' => true,
            'yoda_style' => false,
            'multiline_whitespace_before_semicolons' => false,
            'array_syntax' => ['syntax' => 'short'],
            'modernize_strpos' => true,
            'native_function_invocation' => true,
            'class_attributes_separation' => true,
            'group_import' => true,
            'single_import_per_statement' => false,
            'declare_strict_types' => true,
            'global_namespace_import' => [
                'import_functions' => true,
                'import_classes' => true,
            ],
        ]
    )
    ->setFinder($finder);
