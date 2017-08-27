<?php
/**
 * Created by PhpStorm.
 * User: kisztof
 * Date: 8/27/17
 * Time: 22:35
 */

declare(strict_types=1);

namespace kisztof\Loadbalancer\Host;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Host
 * @package kisztof\Loadbalanceer\Host
 */
class Host implements HostInterface, \JsonSerializable
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $address;

    /**
     * Host constructor.
     *
     * @param string        $id
     * @param string        $address
     */
    public function __construct(string $id, string $address)
    {
        $this->id = $id;
        $this->address = $address;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * {@inheritdoc}
     */
    public function getLoad(): float
    {
        return 1.0;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Request $request): Response
    {
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent(json_encode($this));

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [$this->id, $this->address];
    }
}
