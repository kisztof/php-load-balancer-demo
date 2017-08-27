<?php
/**
 * Created by PhpStorm.
 * User: kisztof
 * Date: 8/27/17
 * Time: 22:19
 */

declare(strict_types=1);

namespace kisztof\Loadbalancer\Algorithm;

use kisztof\Loadbalancer\Exception\NotFoundRegisteredHostsException;
use kisztof\Loadbalancer\Host\HostInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface AlgorithmInterface
 * @package kisztof\Loadbalancer\Algorithm
 */
interface AlgorithmInterface
{
    /**
     * @param Request               $request
     * @param array|HostInterface[] $hosts
     *
     * @return HostInterface
     * @throws NotFoundRegisteredHostsException
     */
    public function getHost(Request $request, array &$hosts): HostInterface;
}
