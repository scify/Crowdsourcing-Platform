<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    // Target PHP 8.2+ for modern Laravel projects
    ->withPhpSets(php82: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        naming: false,
        privatization: true,
        typeDeclarations: true,
        rectorPreset: true,
        earlyReturn: true,
        strictBooleans: true,
    )
    // Add modern PHP features
    ->withSets([
        SetList::PHP_82,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
    ])
    ->withSkip([
        __DIR__ . '/vendor',
        __DIR__ . '/storage',
        __DIR__ . '/bootstrap/cache',
        __DIR__ . '/node_modules',
        // Skip increment optimization to avoid conflicts with Pint
        \Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector::class,
    ])
    // Parallel processing for better performance
    ->withParallel();
