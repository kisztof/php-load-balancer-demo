# Loadbalancer 2022
Example Load Balancer implementation made with PHP with usage of [psr-7](https://www.php-fig.org/psr/psr-7/) standard.

## Requirements
- [PHP 8.1](https://www.php.net/releases/8.1/en.php)
- [Composer](https://getcomposer.org)

## Installation
```shell
git clone git@github.com:kisztof/Loadbalancer.git

composer install -a --no-dev
```

## Example usage

As second argument for LoadBalance constructor pass one of two implemented BalanceStrategies
```injectablephp
$strategy = new \SlomkaPro\Loadbalancer\BalanceStrategy\RoundRobinStrategy();
$lb = new \SlomkaPro\Loadbalancer\LoadBalancer($hosts, $strategy)
$lb->handleRequest($request);
```
Available strategies:
```injectablephp
\SlomkaPro\Loadbalancer\BalanceStrategy\RoundRobinStrategy::class;
\SlomkaPro\Loadbalancer\BalanceStrategy\LoadLimitStrategy::class;
```

## Contribution

To implement new strategy simply use interface
```injectablephp
\SlomkaPro\Loadbalancer\BalanceStrategy\BalanceStrategy::class
```

```shell
git clone git@github.com:kisztof/Loadbalancer.git

composer install
```

Before committing changes simply hit
```shell
composer build
```

## Tests

```shell
./vendor/bin/phpunit
```
or use simply composer script
```shell
composer tests
```
## @TODO

Dynamic load balancing algorithms
- [ ] Least connection
- [ ] Weighted least connection
- [ ] Weighted response time
- [ ] Resource-based
  
Static load balancing algorithms
- [x] Round robin
- [ ] Weighted round robin
- [ ] IP hash

## Some simulations
Example folder contains simulations for both balancing strategies and an implemented simulation process.

```injectablephp
php examples/example_RR.php
php examples/example_LL.php
```