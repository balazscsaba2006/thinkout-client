<?php

declare(strict_types = 1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/..')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
        'align_multiline_comment' => true,
        'array_indentation' => true,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => ['space' => 'single'],
        // `list_syntax` is set to long, because the short syntax causes errors in the translation extractor
        'list_syntax' => ['syntax' => 'long'],
        'mb_str_functions' => true,
        'method_argument_space' => [
            'after_heredoc' => false,
            'keep_multiple_spaces_after_comma' => false,
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'method_chaining_indentation' => true,
        'multiline_comment_opening_closing' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],
        'no_superfluous_elseif' => true,
        'no_useless_else' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
            ],
            'sort_algorithm' => 'none',
        ],
        'phpdoc_align' => false, // This messes up array shape types used for stan
        'phpdoc_no_empty_return' => true,
        'phpdoc_order' => true,
        'phpdoc_summary' => false,
        // `phpdoc_to_comment` rule is disabled because it causes `/** @Ignore */` to be converted to
        // `/* @Ignore */` which is not recognized by translation extractor as valid annotation
        'phpdoc_to_comment' => false,
        // /* @var is not picked up by phpStan so it ignores those objects e.g. in workflow subscribers
        'comment_to_phpdoc' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setRiskyAllowed(true)
;
