<?php

declare(strict_types=1);

namespace SlomkaPro\Loadbalancer\BalanceStrategy;

use SlomkaPro\Loadbalancer\Host;

interface BalanceStrategy
{
    /** @param array<Host> $hosts */
    public function balance(array $hosts): Host;
}
