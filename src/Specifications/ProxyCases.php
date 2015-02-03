<?php namespace Proxyvel\Specifications;

use Proxyvel\Contracts\ProxySpecification;

class ProxyCases implements ProxySpecification
{
    /**
     * @type array
     */
    private $cases = [];

    /**
     * @param array $cases
     */
    public function __construct(array $cases = [])
    {
        $this->cases = $cases;
    }

    /**
     * @param string $case
     */
    public function add($case)
    {
        $this->cases[] = $case;
    }


    /**
     * Given a class name (or any string, actually), tell me if this class
     * should be proxied or not.
     *
     * @param string $className
     * @return bool
     */
    public function shouldProxy($className)
    {
        return in_array($className, $this->cases);
    }
}
