<?php
/**
 * Created by PhpStorm.
 * User: kisztof
 * Date: 8/29/17
 * Time: 00:23
 */

declare(strict_types=1);

namespace kisztof\Loadbalancer\Host;

/**
 * Class Configuration
 * @package Host
 */
class Configuration
{
    /**
     * @var float
     */
    private $load;

    /**
     * Configuration constructor.
     *
     * @param float $load
     */
    public function __construct(float $load = 1)
    {
        $this->load = $load;
    }

    /**
     * @return float
     */
    public function getLoad(): float
    {
        return $this->load;
    }
}
