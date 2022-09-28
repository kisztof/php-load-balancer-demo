<?php

declare(strict_types=1);

namespace SlomkaPro\Loadbalancer\Tests\Unit\BalanceStrategy;

use PHPUnit\Framework\TestCase;
use SlomkaPro\Loadbalancer\BalanceStrategy\LoadLimitStrategy;
use SlomkaPro\Loadbalancer\BalanceStrategy\NoAvailableHostFoundException;
use SlomkaPro\Loadbalancer\Host;

/**
 * @covers \SlomkaPro\Loadbalancer\BalanceStrategy\LoadLimitStrategy
 */
class LoadLimitStrategyTest extends TestCase
{
    public function testLowestLoadStrategy(): void
    {
        $limit = 0.75;
        $strategy = new LoadLimitStrategy($limit);

        $hosts = $this->hostProvider(0.9);
        $hostStub = $this->createStub(Host::class);
        $hostStub->method('getLoad')->willReturn(0.8);
        $hosts[] = $hostStub;
        $host = $strategy->balance($hosts);

        self::assertSame(0.8, $host->getLoad());
    }

    public function testGrabFirstLowerThanSetLimit(): void
    {
        $limit = 0.75;
        $strategy = new LoadLimitStrategy($limit);

        $hosts = $this->hostProvider(0.7);
        $hostStub = $this->createStub(Host::class);
        $hostStub->method('getLoad')->willReturn(0.1);
        $hosts[] = $hostStub;
        $host = $strategy->balance($hosts);

        self::assertSame(0.7, $host->getLoad());
    }

    public function testEmptyHostListException(): void
    {
        self::expectExceptionObject(new NoAvailableHostFoundException('Host list is empty!'));

        $strategy = new LoadLimitStrategy();
        $strategy->balance([]);
    }

    /**
     * @return Host[]
     */
    private function hostProvider(float $value): array
    {
        $hosts = [];
        for ($i = 1; $i <= 10; $i++) {
            $stub = $this->createStub(Host::class);
            $stub
                ->method('getLoad')->willReturn($value);
            $hosts[] = $stub;
        }

        return $hosts;
    }
}
