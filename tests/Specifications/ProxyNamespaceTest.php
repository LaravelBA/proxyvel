<?php namespace Proxyvel\Specifications;


class ProxyNamespaceTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_match_namespaces()
    {
        $spec = new ProxyNamespace(['A\\Namespace', 'Another\\Namespace']);

        $this->assertTrue($spec->shouldProxy('A\\Namespace\\Class'));
        $this->assertTrue($spec->shouldProxy('A\\Namespace\\Package\\Name'));
        $this->assertTrue($spec->shouldProxy('Another\\Namespace\\Class'));
        $this->assertFalse($spec->shouldProxy('Yet\\Another\\Namespace\\Class'));
        $this->assertFalse($spec->shouldProxy('Whatever\\A\\Namespace\\Class\\Is'));
    }
}
