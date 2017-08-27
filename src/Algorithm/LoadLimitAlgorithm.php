<?php
/**
 * Created by PhpStorm.
 * User: kisztof
 * Date: 8/27/17
 * Time: 23:07
 */

declare(strict_types=1);

namespace kisztof\Loadbalancer\Algorithm;

use kisztof\Loadbalancer\Exception\NotFoundRegisteredHostsException;
use kisztof\Loadbalancer\Host\HostInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoadLimitAlgorithm
 * @package kisztof\Loadbalancer\Algorithm
 */
class LoadLimitAlgorithm implements AlgorithmInterface
{
    /**
     * @var float
     */
    private $loadLimit;

    /**
     * LoadLimitAlgorithm constructor.
     *
     * @param float $loadLimit
     */
    public function __construct(float $loadLimit)
    {
        if ($loadLimit < 0 || $loadLimit > 1) {
            throw new \BadMethodCallException('Load limit should be between 0 and 1');
        }
        $this->loadLimit = $loadLimit;
    }

    /**
     * {@inheritdoc}
     */
    public function getHost(Request $request, array &$hosts): HostInterface
    {
        if (empty($hosts)) {
            throw new NotFoundRegisteredHostsException('Hosts list is empty');
        }

        /** @var HostInterface $host */
        $currentHost = reset($hosts);

        /** @var HostInterface $host */
        foreach ($hosts as $host) {
            $load = $host->getLoad();
            if ($load < $this->loadLimit) {
                return $host;
            }

            if ($currentHost === null || $load < $currentHost->getLoad()) {
                $currentHost = $host;
            }
        }

        return $currentHost;
    }
}
