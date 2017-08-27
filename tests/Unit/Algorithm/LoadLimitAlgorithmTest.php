<?php
/**
 * Created by PhpStorm.
 * User: kisztof
 * Date: 8/28/17
 * Time: 00:03
 */

declare(strict_types=1);

namespace Unit\Algorithm;

use kisztof\Loadbalancer\Algorithm\LoadLimitAlgorithm;
use kisztof\Loadbalancer\Exception\NotFoundRegisteredHostsException;
use kisztof\Loadbalancer\Host\HostInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoadLimitAlgorithm
 * @package Unit\Algorithm
 */
class LoadLimitAlgorithmTest extends TestCase
{
    public function testGetHostNotFoundRegisteredHostsException()
    {
        /** @var Request $request */
        $request = $this->prophesize(Request::class)->reveal();
        $algorithm = new LoadLimitAlgorithm(0.75);
        $this->expectException(NotFoundRegisteredHostsException::class);
        $hosts = [];
        $algorithm->getHost($request, $hosts);
    }

    /**
     */
    public function testGetHostBadMethodCallExceptionHigherLoad()
    {
        $this->expectException(\BadMethodCallException::class);
        $algorithm = new LoadLimitAlgorithm(1.1);
    }

    /**
     */
    public function testGetHostBadMethodCallExceptionLowerLoad()
    {
        $this->expectException(\BadMethodCallException::class);
        $algorithm = new LoadLimitAlgorithm(-1);
    }

    /**
     */
    public function testGetHost()
    {
        /** @var Request $request */
        $request = $this->prophesize(Request::class)->reveal();
        $host1 = $this->prophesize(HostInterface::class);
        $host1->getId()->willReturn('host-1');
        $host1->getLoad()->willReturn(0.75);
        $host2 = $this->prophesize(HostInterface::class);
        $host2->getId()->willReturn('host-2');
        $host2->getLoad()->willReturn(0.5);
        $host3 = $this->prophesize(HostInterface::class);
        $host3->getId()->willReturn('host-3');
        $host3->getLoad()->willReturn(0.1);
        $algorithm = new LoadLimitAlgorithm(0.75);
        $hosts = [$host1->reveal(), $host2->reveal(), $host3->reveal()];
        $host = $algorithm->getHost($request, $hosts);
        $this->assertEquals('host-2', $host->getId());
    }

    public function testGetHostWithSameLoad()
    {
        /** @var Request $request */
        $request = $this->prophesize(Request::class)->reveal();
        $host1 = $this->prophesize(HostInterface::class);
        $host1->getId()->willReturn('host-1');
        $host1->getLoad()->willReturn(0.9);
        $host2 = $this->prophesize(HostInterface::class);
        $host2->getId()->willReturn('host-2');
        $host2->getLoad()->willReturn(0.9);
        $host3 = $this->prophesize(HostInterface::class);
        $host3->getId()->willReturn('host-3');
        $host3->getLoad()->willReturn(0.9);
        $algorithm = new LoadLimitAlgorithm(0.75);
        $hosts = [$host1->reveal(), $host2->reveal(), $host3->reveal()];
        $host = $algorithm->getHost($request, $hosts);
        $this->assertEquals('host-1', $host->getId());
    }
}
