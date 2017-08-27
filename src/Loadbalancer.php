<?php
/**
 * Created by PhpStorm.
 * User: kisztof
 * Date: 8/27/17
 * Time: 22:17
 */

declare(strict_types=1);

namespace kisztof\Loadbalancer;

use kisztof\Loadbalancer\Host\HostInterface;
use kisztof\Loadbalancer\Exception\NotFoundRegisteredHostsException;
use kisztof\Loadbalancer\Algorithm\AlgorithmInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Loadbalanceer
 * @package kisztof\Loadbalancer
 */
class Loadbalancer implements LoadbalancerInterface
{
    /**
     * @var array|HostInterface[]
     */
    private $hosts;

    /**
     * @var AlgorithmInterface
     */
    private $algorithm;

    /**
     * Loadbalancer constructor.
     *
     * @param array|HostInterface[] $hosts
     * @param AlgorithmInterface    $algorithm
     */
    public function __construct(array $hosts, AlgorithmInterface $algorithm)
    {
        foreach ($hosts as $host) {
            $this->hosts[$host->getId()] = $host;
        }
        $this->algorithm = $algorithm;
    }

    /*
     * {@inheritdoc}
     */
    public function handleRequest(Request $request): Response
    {
        if (empty($this->hosts)) {
            throw new NotFoundRegisteredHostsException();
        }

        $host = $this->algorithm->getHost($request, $this->hosts);

        return $host->handleRequest($request);
    }
}
