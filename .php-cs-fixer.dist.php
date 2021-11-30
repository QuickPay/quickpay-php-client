<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . DIRECTORY_SEPARATOR . 'QuickPay')
    ->in(__DIR__ . DIRECTORY_SEPARATOR . 'Tests')
    ->append(['.php-cs-fixer.dist.php']);

$rules = [
    '@Symfony'               => true,
    '@PSR2'                  => true,
    'phpdoc_to_comment'      => false,
    'array_syntax'           => ['syntax' => 'short'],
    'yoda_style'             => false,
    'binary_operator_spaces' => [
        'operators' => [
            '=>' => 'align',
            '='  => 'align',
        ],
    ],
    'concat_space'            => ['spacing' => 'one'],
    'not_operator_with_space' => false,
];

$rules['increment_style'] = ['style' => 'post'];

return (new PhpCsFixer\Config())
    ->setUsingCache(true)
    ->setRules($rules)
    ->setFinder($finder);
