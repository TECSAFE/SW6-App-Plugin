<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'var',
        'vendor',
        'files',
        'shopware-source',
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PER-CS2.0' => true,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
