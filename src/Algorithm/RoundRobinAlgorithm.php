<?php
/**
 * Created by PhpStorm.
 * User: kisztof
 * Date: 8/27/17
 * Time: 22:24
 */

declare(strict_types=1);

namespace kisztof\Loadbalancer\Algorithm;

use kisztof\Loadbalancer\Exception\NotFoundRegisteredHostsException;
use kisztof\Loadbalancer\Host\HostInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RoundRobinAlgorithm
 * @package kisztof\Loadbalancer\Algorithm
 */
class RoundRobinAlgorithm implements AlgorithmInterface
{
    /**
     * {@inheritdoc}
     */
    public function getHost(Request $request, array &$hosts): HostInterface
    {
        if (empty($hosts)) {
            throw new NotFoundRegisteredHostsException('Hosts list is empty');
        }

        $host = current($hosts);

        if (next($hosts) === false) {
            reset($hosts);
        }

        return $host;
    }
}
