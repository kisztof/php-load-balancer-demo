<?php
/**
 * Created by PhpStorm.
 * User: kisztof
 * Date: 8/27/17
 * Time: 23:23
 */

declare(strict_types=1);

namespace Unit;

use kisztof\Loadbalancer\Algorithm\AlgorithmInterface;
use kisztof\Loadbalancer\Exception\NotFoundRegisteredHostsException;
use kisztof\Loadbalancer\Loadbalancer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoadbalancerTest
 * @package kisztof\Loadbalancer
 */
class LoadbalancerTest extends TestCase
{
    /**
     */
    public function testHandleRequestNoRegisteredHostException()
    {
        /** @var AlgorithmInterface $algorithm */
        $algorithm = $this->prophesize(AlgorithmInterface::class)->reveal();
        /** @var Request $request */
        $request = $this->prophesize(Request::class)->reveal();
        $loadBalancer = new Loadbalancer([], $algorithm);

        $this->expectException(NotFoundRegisteredHostsException::class);
        $loadBalancer->handleRequest($request);
    }
}
