<?php namespace Proxyvel\Specifications;

use Proxyvel\Contracts\ProxySpecification;

class ProxyCollection implements ProxySpecification
{
    /**
     * @type array
     */
    private $proxySpecifications = [];

    /**
     * @param array $proxySpecifications
     */
    public function __construct(array $proxySpecifications = [])
    {
        $this->proxySpecifications = $proxySpecifications;
    }

    /**
     * @param \Proxyvel\Contracts\ProxySpecification $proxySpecification
     */
    public function addSpecification(ProxySpecification $proxySpecification)
    {
        $this->proxySpecifications[] = $proxySpecification;
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
        foreach ($this->proxySpecifications as $proxySpecification)
        {
            /** @type ProxySpecification $proxySpecification */
            if ($proxySpecification->shouldProxy($className))
            {
                return true;
            }
        }

        return false;
    }
}
