<?php namespace Tests;

use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use Proxyvel\Application;
use Proxyvel\Specifications\ProxyNamespace;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @type Application
     */
    private $app;

    public function setUp()
    {
        $this->app = new Application(
            new ProxyNamespace(['Tests\\Fixtures']),
            new LazyLoadingValueHolderFactory()
        );
    }

    /** @test */
    public function it_should_proxy_calls_to_app_make()
    {
        /** @type \Tests\Fixtures\TestClass $proxy */
        $proxy = $this->app->make('Tests\\Fixtures\\TestClass');

        $this->assertInstanceOf('ProxyManager\Proxy\LazyLoadingInterface', $proxy);
        $this->assertInstanceOf('Tests\\Fixtures\\TestClass', $proxy);

        $this->assertEquals('Yes sir, yes I am.', $proxy->imReal());
    }

    /** @test */
    public function it_should_proxy_dependencies_as_well()
    {
        /** @type \Tests\Fixtures\WithDependencies $proxy */
        $proxy = $this->app->make('Tests\\Fixtures\\WithDependencies');

        $dep = $proxy->getTestClass();

        $this->assertInstanceOf('ProxyManager\Proxy\LazyLoadingInterface', $dep);

        $this->assertEquals('Yes sir, yes I am.', $dep->imReal());
    }
}