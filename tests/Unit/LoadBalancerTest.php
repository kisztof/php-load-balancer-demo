<?php

declare(strict_types=1);

namespace SlomkaPro\Loadbalancer\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use SlomkaPro\Loadbalancer\BalanceStrategy\BalanceStrategy;
use SlomkaPro\Loadbalancer\Host;
use SlomkaPro\Loadbalancer\LoadBalancer;

/**
 * @covers \SlomkaPro\Loadbalancer\LoadBalancer
 */
class LoadBalancerTest extends TestCase
{
    public function testHandleRequest(): void
    {
        $host = $this->createMock(Host::class);
        $host
            ->expects($this->once())
            ->method('handleRequest');

        $balanceStrategyMock = $this->createMock(BalanceStrategy::class);
        $balanceStrategyMock
            ->expects($this->once())
            ->method('balance')
            ->willReturn($host);

        $loadBalancer = new LoadBalancer([], $balanceStrategyMock);
        $loadBalancer->handleRequest($this->createStub(RequestInterface::class));
    }
}
