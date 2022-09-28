<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);

    $ecsConfig->parallel();

    $ecsConfig->sets([
        SetList::PSR_12,
        SetList::STRICT,
        SetList::CLEAN_CODE,
        SetList::CONTROL_STRUCTURES,
        SetList::SPACES,
    ]);
};
