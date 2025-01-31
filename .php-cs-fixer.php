<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/assets',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

if (!\file_exists(__DIR__ . '/var')) {
    \mkdir(__DIR__ . '/var');
}

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setCacheFile(__DIR__.'/var/.php_cs.cache')
    ->setRules([
        '@PSR2' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'align_single_space_minimal',
            ]
        ],
        'class_attributes_separation' => ['elements' => ['const' => 'one', 'property' => 'one', 'method' => 'one']],
        'concat_space' => ['spacing' => 'one'],
        'declare_strict_types' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'php_unit_test_class_requires_covers' => false,
        'return_type_declaration' => ['space_before' => 'none'],
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
    ])
    ->setFinder($finder);
