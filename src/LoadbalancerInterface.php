<?php
declare(strict_types=1);

namespace kisztof\Loadbalancer;

use kisztof\Loadbalancer\Exception\NotFoundRegisteredHostsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface LoadbalancerInterface
 */
interface LoadbalancerInterface
{
    /**
     * @return Response
     * @throws  NotFoundRegisteredHostsException
     */
    public function handleRequest(Request $request): Response;
}
