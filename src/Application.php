<?php namespace Proxyvel;

use ProxyManager\Factory\AbstractLazyFactory;
use Proxyvel\Contracts\ProxySpecification;
use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication
{
    /**
     * @type \Proxyvel\Contracts\ProxySpecification
     */
    private $proxySpecification;

    /**
     * @type \ProxyManager\Factory\AbstractBaseFactory
     */
    private $proxyFactory;

    /**
     * @param \Proxyvel\Contracts\ProxySpecification    $proxySpecification
     * @param \ProxyManager\Factory\AbstractLazyFactory $proxyFactory
     */
    public function __construct(ProxySpecification $proxySpecification, AbstractLazyFactory $proxyFactory)
    {
        $this->proxySpecification = $proxySpecification;
        $this->proxyFactory       = $proxyFactory;
    }

    /**
     * @param string $abstract
     * @param array  $parameters
     *
     * @return \ProxyManager\Proxy\LazyLoadingInterface|object
     */
    public function make($abstract, $parameters = array())
    {
        if ($this->proxySpecification->shouldProxy($abstract))
        {
            return $this->proxyFactory->createProxy($abstract, function(& $wrappedObject, $proxy, $method, $parameters, & $initializer) use ($abstract, $parameters){
                $wrappedObject = parent::make($abstract, $parameters);
                $initializer = null;

                return true;
            });
        }

        return parent::make($abstract, $parameters);
    }
}