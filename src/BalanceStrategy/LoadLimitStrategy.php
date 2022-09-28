<?php

declare(strict_types=1);

namespace SlomkaPro\Loadbalancer\BalanceStrategy;

use SlomkaPro\Loadbalancer\Host;

class LoadLimitStrategy implements BalanceStrategy
{
    public function __construct(private readonly float $limit = 0.75)
    {
    }

    /**
     * @param array<Host> $hosts
     */
    public function balance(array $hosts): Host
    {
        if (empty($hosts)) {
            throw new NoAvailableHostFoundException('Host list is empty!');
        }

        foreach ($hosts as $host) {
            if ($host->getLoad() < $this->limit) {
                return $host;
            }
        }

        $lowestLoaded = $hosts[0];
        foreach ($hosts as $host) {
            if ($lowestLoaded->getLoad() > $host->getLoad()) {
                $lowestLoaded = $host;
            }
        }

        return $lowestLoaded;
    }
}
