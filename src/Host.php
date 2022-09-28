<?php

declare(strict_types=1);

namespace SlomkaPro\Loadbalancer;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Host
{
    public function getLoad(): float;

    public function handleRequest(RequestInterface $request): ResponseInterface;
}
