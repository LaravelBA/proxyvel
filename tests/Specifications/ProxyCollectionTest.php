<?php namespace Proxyvel\Specifications;

class ProxyCollectionTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_hold_test_for_any_of_the_given_specs()
    {
        $spec = new ProxyCollection([
            new ProxyByRegExp(['/^ba[rz]$/']),
            new ProxyNamespace(['A\\Namespace']),
            new ProxyCases(['A\\Class\\Name'])
        ]);

        $this->assertTrue($spec->shouldProxy('bar'));
        $this->assertTrue($spec->shouldProxy('baz'));
        $this->assertTrue($spec->shouldProxy('A\\Namespace\\Class'));
        $this->assertTrue($spec->shouldProxy('A\\Class\\Name'));

        $this->assertFalse($spec->shouldProxy('foo'));
        $this->assertFalse($spec->shouldProxy('bat'));
        $this->assertFalse($spec->shouldProxy('Another\\Namespace\\Class'));
        $this->assertFalse($spec->shouldProxy('A\\Class\\Without\\A\\Name'));
    }
}
