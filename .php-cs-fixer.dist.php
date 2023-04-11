<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules(
        [
            '@Symfony'                              => true,
            '@Symfony:risky'                        => true,
            'no_unreachable_default_argument_value' => false,
            'braces'                                => ['allow_single_line_closure' => true],
            'heredoc_to_nowdoc'                     => false,
            'phpdoc_annotation_without_dot'         => false,
            'strict_comparison'                     => true,
            'concat_space'                          => [
                'spacing' => 'one',
            ],
            'binary_operator_spaces' => [
                'default' => 'align_single_space_minimal',
            ],
            'array_indentation'           => true,
            'blank_line_before_statement' => [
                'statements' => [
                    'return',
                    'continue',
                    'exit',
                    'for',
                    'foreach',
                    'declare',
                    'if',
                    'return',
                    'throw',
                    'break',
                ],
            ],
            'yoda_style'                             => true,
            'no_superfluous_phpdoc_tags'             => true,
            'combine_consecutive_issets'             => true,
            'combine_consecutive_unsets'             => true,
            'method_chaining_indentation'            => true,
            'php_unit_test_case_static_method_calls' => ['call_type' => 'this'],
            'single_line_throw'                      => false,
            'mb_str_functions'                       => true,
        ]
    )
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;