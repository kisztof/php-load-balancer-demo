<?php
/**
 * Created by PhpStorm.
 * User: kisztof
 * Date: 8/27/17
 * Time: 22:26
 */

declare(strict_types=1);

namespace kisztof\Loadbalancer\Host;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface HostInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getAddress(): string;

    /**
     * @return float
     */
    public function getLoad(): float;

    /**
     * @return Response
     */
    public function handleRequest(Request $request): Response;
}
