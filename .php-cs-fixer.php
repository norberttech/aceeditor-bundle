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
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => true,
        'class_attributes_separation' => ['elements' => ['const' => 'one', 'property' => 'one', 'method' => 'one']],
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'psr_autoloading' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'strict_param' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
    ])
    ->setFinder($finder);
