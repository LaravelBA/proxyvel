<?php namespace Proxyvel\Specifications;

use Proxyvel\Contracts\ProxySpecification;

class ProxyNamespace implements ProxySpecification
{
    /**
     * @type array
     */
    private $namespaces = [];

    /**
     * @param array $namespaces
     */
    public function __construct(array $namespaces = [])
    {
        $this->namespaces = $namespaces;
    }

    /**
     * @param string $namespace
     */
    public function addNamespace($namespace)
    {
        $this->namespaces[] = $namespace;
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
        foreach ($this->namespaces as $namespace)
        {
            if (strpos($className, $namespace) === 0)
            {
                return true;
            }
        }

        return false;
    }
}
