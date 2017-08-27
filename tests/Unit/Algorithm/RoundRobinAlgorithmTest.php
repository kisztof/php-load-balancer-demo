<?php
/**
 * Created by PhpStorm.
 * User: kisztof
 * Date: 8/28/17
 * Time: 00:15
 */

declare(strict_types=1);

namespace Unit\Algorithm;

use kisztof\Loadbalancer\Algorithm\RoundRobinAlgorithm;
use kisztof\Loadbalancer\Exception\NotFoundRegisteredHostsException;
use kisztof\Loadbalancer\Host\HostInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RoundRobinAlgorithmTest extends TestCase
{
    /**
     */
    public function testGetHostNotFoundRegisteredHostsException()
    {
        /** @var Request $request */
        $request = $this->prophesize(Request::class)->reveal();
        $algorithm = new RoundRobinAlgorithm();
        $this->expectException(NotFoundRegisteredHostsException::class);
        $hosts = [];
        $algorithm->getHost($request, $hosts);
    }

    /**
     */
    public function testGetHost()
    {
        /** @var Request $request */
        $request = $this->prophesize(Request::class)->reveal();
        $host1 = $this->prophesize(HostInterface::class);
        $host1->getId()->willReturn('host-1');
        $host1 = $host1->reveal();
        $host2 = $this->prophesize(HostInterface::class);
        $host2->getId()->willReturn('host-2');
        $host2 = $host2->reveal();
        $host3 = $this->prophesize(HostInterface::class);
        $host3->getId()->willReturn('host-3');
        $host3 = $host3->reveal();

        $algorithm = new RoundRobinAlgorithm();
        $results = [];
        $hosts = [$host1, $host2, $host3];
        $responseHosts = [];
        for ($i = 0; $i < 7; $i++) {
            $host = $algorithm->getHost($request, $hosts);
            $results[$host->getId()] = $host;
            $responseHosts[] = $host->getId();
        }
        $this->assertCount(3, $results);
        $this->assertEquals(['host-1', 'host-2', 'host-3', 'host-1', 'host-2', 'host-3', 'host-1'], $responseHosts);
    }
}
