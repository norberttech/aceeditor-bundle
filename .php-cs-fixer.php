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
        'psr_autoloading' => true,
        'strict_param' => true,
        'ordered_imports' => true,
        'blank_line_before_statement' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'return_type_declaration' => ['space_before' => 'none'],
        'class_attributes_separation' => ['elements' => ['const' => 'one', 'property' => 'one', 'method' => 'one']],
        'no_unused_imports' => true,
        'declare_strict_types' => true,
        'blank_line_after_opening_tag' => true
    ])
    ->setFinder($finder);
