<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {

    $rectorConfig->phpVersion(PhpVersion::PHP_81);
    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon');

    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests'
    ]);


    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_81,
        PHPUnitSetList::PHPUNIT_91,
        PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD,
    ]);



};
