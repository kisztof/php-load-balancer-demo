<?php
declare(strict_types=1);

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SlomkaPro\Loadbalancer\BalanceStrategy\BalanceStrategy;
use SlomkaPro\Loadbalancer\Host;
use SlomkaPro\Loadbalancer\LoadBalancer;

require_once __DIR__.'/../vendor/autoload.php';

interface LoadMonitor
{
    public function incLoad(): void;

    public function decLoad(): void;
}

class Simulation
{
    /** @var Host[]|LoadMonitor[] */
    private array $hosts = [];

    public function __construct(int $hostCount = 1, private readonly float $fps = 2)
    {
        $this->hosts = $this->provideHosts($hostCount);
    }

    public function sleep(): void
    {
        $time = (1 / $this->fps) * 1000000;
        usleep((int)$time);
    }

    public function runtime(): void
    {
        echo sprintf(
            "Load Monitor: [%s]\n",
            implode(
                ', ',
                array_map(
                    fn(Host $host): string => sprintf('[%s: %s]', $host->id, $host->getLoad()),
                    $this->hosts
                )
            )
        );

        foreach ($this->hosts as $id => $hostLoad) {
            $hostLoad->decLoad();
        }
    }

    public function simulation(BalanceStrategy $balanceStrategy): void
    {
        $loadBalancer = new LoadBalancer($this->hosts, $balanceStrategy);
        while (true) {
            $this->sleep();
            try {
                $loadBalancer->handleRequest(
                    new class() implements RequestInterface {
                        public function getProtocolVersion()
                        {
                            // TODO: Implement getProtocolVersion() method.
                        }

                        public function withProtocolVersion($version)
                        {
                            // TODO: Implement withProtocolVersion() method.
                        }

                        public function getHeaders()
                        {
                            // TODO: Implement getHeaders() method.
                        }

                        public function hasHeader($name)
                        {
                            // TODO: Implement hasHeader() method.
                        }

                        public function getHeader($name)
                        {
                            // TODO: Implement getHeader() method.
                        }

                        public function getHeaderLine($name)
                        {
                            // TODO: Implement getHeaderLine() method.
                        }

                        public function withHeader($name, $value)
                        {
                            // TODO: Implement withHeader() method.
                        }

                        public function withAddedHeader($name, $value)
                        {
                            // TODO: Implement withAddedHeader() method.
                        }

                        public function withoutHeader($name)
                        {
                            // TODO: Implement withoutHeader() method.
                        }

                        public function getBody()
                        {
                            // TODO: Implement getBody() method.
                        }

                        public function withBody(\Psr\Http\Message\StreamInterface $body)
                        {
                            // TODO: Implement withBody() method.
                        }

                        public function getRequestTarget()
                        {
                            // TODO: Implement getRequestTarget() method.
                        }

                        public function withRequestTarget($requestTarget)
                        {
                            // TODO: Implement withRequestTarget() method.
                        }

                        public function getMethod()
                        {
                            // TODO: Implement getMethod() method.
                        }

                        public function withMethod($method)
                        {
                            // TODO: Implement withMethod() method.
                        }

                        public function getUri()
                        {
                            // TODO: Implement getUri() method.
                        }

                        public function withUri(\Psr\Http\Message\UriInterface $uri, $preserveHost = false)
                        {
                            // TODO: Implement withUri() method.
                        }
                    }
                );
            } catch (\Exception $e) {
                echo "Skipped due to heavy load.\n";
                sleep(2);
            }
        }
    }

    /**
     * @return Host[]
     */
    private function provideHosts(int $count): array
    {
        $hosts = [];
        for ($id = 0; $id < $count; $id++) {
            $hosts[] = new class($id, $this) implements Host, LoadMonitor {
                private float $load = 0.0;

                public function __construct(public readonly int $id, private readonly Simulation $simulation)
                {
                }

                public function getLoad(): float
                {
                    return $this->load;
                }

                public function handleRequest(RequestInterface $request): ResponseInterface
                {
                    $currentLoad = $this->getLoad();
                    $this->incLoad();
                    $this->simulation->runtime();
                    if ($currentLoad > 1) {
                        throw new \Exception();
                    }

                    echo sprintf(
                        "%s: Request is handled by Host: %s.\n",
                        time(),
                        $this->id,
                    );

                    return new class() implements ResponseInterface {

                        public function getProtocolVersion()
                        {
                            // TODO: Implement getProtocolVersion() method.
                        }

                        public function withProtocolVersion($version)
                        {
                            // TODO: Implement withProtocolVersion() method.
                        }

                        public function getHeaders()
                        {
                            // TODO: Implement getHeaders() method.
                        }

                        public function hasHeader($name)
                        {
                            // TODO: Implement hasHeader() method.
                        }

                        public function getHeader($name)
                        {
                            // TODO: Implement getHeader() method.
                        }

                        public function getHeaderLine($name)
                        {
                            // TODO: Implement getHeaderLine() method.
                        }

                        public function withHeader($name, $value)
                        {
                            // TODO: Implement withHeader() method.
                        }

                        public function withAddedHeader($name, $value)
                        {
                            // TODO: Implement withAddedHeader() method.
                        }

                        public function withoutHeader($name)
                        {
                            // TODO: Implement withoutHeader() method.
                        }

                        public function getBody()
                        {
                            // TODO: Implement getBody() method.
                        }

                        public function withBody(\Psr\Http\Message\StreamInterface $body)
                        {
                            // TODO: Implement withBody() method.
                        }

                        public function getStatusCode()
                        {
                            // TODO: Implement getStatusCode() method.
                        }

                        public function withStatus($code, $reasonPhrase = '')
                        {
                            // TODO: Implement withStatus() method.
                        }

                        public function getReasonPhrase()
                        {
                            // TODO: Implement getReasonPhrase() method.
                        }
                    };
                }

                public function incLoad(): void
                {
                    $this->load += rand(90, 100) / 100;
                }

                public function decLoad(): void
                {
                    $currentLoad = $this->load - rand(10, 30) / 100;
                    $this->load = max($currentLoad, 0);
                }
            };
        }

        return $hosts;
    }
}


