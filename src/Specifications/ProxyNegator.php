<?php namespace Proxyvel\Specifications;

use Proxyvel\Contracts\ProxySpecification;

class ProxyNegator implements ProxySpecification
{
    /**
     * @type \Proxyvel\Contracts\ProxySpecification
     */
    private $proxySpecification;

    /**
     * @param \Proxyvel\Contracts\ProxySpecification $proxySpecification
     */
    public function __construct(ProxySpecification $proxySpecification)
    {
        $this->proxySpecification = $proxySpecification;
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
        return ! $this->proxySpecification->shouldProxy($className);
    }
}
