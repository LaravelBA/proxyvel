<?php namespace Proxyvel\Specifications;

class ProxyEverythingTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_proxy_all_the_things()
    {
        $spec = new ProxyEverything;

        $this->assertTrue($spec->shouldProxy(uniqid()));
        $this->assertTrue($spec->shouldProxy(uniqid()));
        $this->assertTrue($spec->shouldProxy(uniqid()));
    }
}
