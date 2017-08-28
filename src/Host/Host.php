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
     * @var Configuration
     */
    private $configuration;

    /**
     * Host constructor.
     *
     * @param string        $id
     * @param string        $address
     * @param Configuration $configuration
     */
    public function __construct(string $id, string $address, Configuration $configuration)
    {
        $this->id = $id;
        $this->address = $address;
        $this->configuration = $configuration;
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
        return $this->configuration->getLoad();
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
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
