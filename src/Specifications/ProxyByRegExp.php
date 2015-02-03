<?php namespace Proxyvel\Specifications;

use Proxyvel\Contracts\ProxySpecification;

class ProxyByRegExp implements ProxySpecification
{
    /**
     * @type array
     */
    private $regExps = [];

    /**
     * @param array $regExps
     */
    public function __construct(array $regExps = [])
    {
        $this->regExps = $regExps;
    }

    /**
     * @param string $regExps
     */
    public function addRegExp($regExp)
    {
        $this->regExps[] = $regExp;
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
        foreach ($this->regExps as $regExp)
        {
            if ((bool) preg_match($regExp, $className))
            {
                return true;
            }
        }

        return false;
    }
}
