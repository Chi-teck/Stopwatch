<?php

declare(strict_types=1);

use PhpCsFixer\Runner\Parallel\ParallelConfig;

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

$rules = [
    '@PER-CS2.0' => true,
    '@PER-CS2.0:risky' => true,
    '@PHP84Migration' => true,
    '@PhpCsFixer' => true,
    '@PhpCsFixer:risky' => true,
    'declare_strict_types' => true,
    'phpdoc_summary' => false,
    'no_superfluous_phpdoc_tags' => ['remove_inheritdoc' => false],
    'native_function_invocation' => ['include' => ['@all']],
    'native_constant_invocation' => ['include' => ['@all']],
    'concat_space' => ['spacing' => 'one'],
    'yoda_style' => false,
    'date_time_immutable' => true,
    'final_class' => true,
    'final_public_method_for_abstract_class' => true,
    'nullable_type_declaration_for_default_null_value' => true,
    'php_unit_internal_class' => false,
    'blank_line_before_statement' => false,
    'numeric_literal_separator' => true,
    'ordered_class_elements' => [
        'order' => [
            'use_trait',
            'case',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property_public_static',
            'property_protected_static',
            'property_private_static',
            'property_public',
            'property_protected',
            'property_private',
            'construct',
            'destruct',
            'method_public_abstract_static',
            'method_public',
            'method_public_static',
            'method_protected_static',
            'method_protected',
            'method_protected_abstract_static',
            'method_private_static',
            'method_private',
            'method_public_abstract',
            'method_protected_abstract',
        ],
    ],
];

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setCacheFile(__DIR__ . '/var/' . \basename(__FILE__, '.dist.php') . '.cache')
    ->setRules($rules)
    ->setParallelConfig(new ParallelConfig(4))
    ->setFinder($finder);
