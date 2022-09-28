<?php

declare(strict_types=1);

namespace SlomkaPro\Loadbalancer\BalanceStrategy;

use SlomkaPro\Loadbalancer\Host;

class RoundRobinStrategy implements BalanceStrategy
{
    private int $lastUsed = 0;

    /**
     * @param Host[] $hosts
     */
    public function balance(array $hosts): Host
    {
        if (empty($hosts)) {
            throw new NoAvailableHostFoundException('Host list is empty!');
        }

        if ($this->lastUsed >= count($hosts)) {
            $this->lastUsed = 0;
        }

        return $hosts[$this->lastUsed++];
    }
}
