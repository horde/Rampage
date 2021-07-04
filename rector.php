<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\Set\ValueObject\DowngradeLevelSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
    ]);

    // register a single rule
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);
    $rectorConfig->import(DowngradeLevelSetList::DOWN_TO_PHP_81);
    // define sets of rules
    $rectorConfig->sets([
            LevelSetList::UP_TO_PHP_81,
            PHPUnitLevelSetList::UP_TO_PHPUNIT_90,
            SetList::CODE_QUALITY,
        ]);
};
