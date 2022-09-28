<?php

declare(strict_types=1);

namespace SlomkaPro\Loadbalancer\Tests\Unit\BalanceStrategy;

use PHPUnit\Framework\TestCase;
use SlomkaPro\Loadbalancer\BalanceStrategy\NoAvailableHostFoundException;
use SlomkaPro\Loadbalancer\BalanceStrategy\RoundRobinStrategy;
use SlomkaPro\Loadbalancer\Host;

/**
 * @covers \SlomkaPro\Loadbalancer\BalanceStrategy\RoundRobinStrategy
 */
class RoundRobinStrategyTest extends TestCase
{
    public function testRoundRobinOnce(): void
    {
        $strategy = new RoundRobinStrategy();
        $hosts = $this->hostProvider();
        $strategy->balance($hosts)->getLoad();
        $strategy->balance($hosts)->getLoad();
        $strategy->balance($hosts)->getLoad();
        $strategy->balance($hosts)->getLoad();
    }

    /**
     * @return Host[]
     */
    public function hostProvider(): array
    {
        $hosts = [];
        for ($i = 0; $i < 3; $i++) {
            $stub = $this->createMock(Host::class);
            $stub
                ->expects($this->atLeastOnce())
                ->method('getLoad');
            $hosts[] = $stub;
        }

        return $hosts;
    }

    public function testEmptyHostListException(): void
    {
        self::expectExceptionObject(new NoAvailableHostFoundException('Host list is empty!'));

        $strategy = new RoundRobinStrategy();
        $strategy->balance([]);
    }
}
