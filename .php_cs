<?php

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        // 'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
    );
