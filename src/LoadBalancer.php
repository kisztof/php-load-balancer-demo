<?php

declare(strict_types=1);

namespace SlomkaPro\Loadbalancer;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SlomkaPro\Loadbalancer\BalanceStrategy\BalanceStrategy;

class LoadBalancer
{
    /** @param Host[] $hosts */
    public function __construct(
        private readonly array $hosts,
        private readonly BalanceStrategy $balanceStrategy
    ) {
    }

    public function handleRequest(RequestInterface $request): ResponseInterface
    {
        $host = $this->balanceStrategy->balance($this->hosts);

        return $host->handleRequest($request);
    }
}
