<?php namespace Proxyvel\Specifications;

class ProxyNegatorTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_negate_regexps()
    {
        $spec = new ProxyNegator(new ProxyByRegExp(['/^fooba[rz]$/']));

        $this->assertTrue($spec->shouldProxy(uniqid()));

        $this->assertFalse($spec->shouldProxy('foobar'));
        $this->assertFalse($spec->shouldProxy('foobaz'));
    }

    /** @test */
    public function it_should_negate_all_the_things()
    {
        $spec = new ProxyNegator(new ProxyEverything);

        $this->assertFalse($spec->shouldProxy(uniqid()));
        $this->assertFalse($spec->shouldProxy(uniqid()));
        $this->assertFalse($spec->shouldProxy(uniqid()));
    }

    /** @test */
    public function it_should_not_proxy_given_cases()
    {
        $spec = new ProxyNegator(new ProxyCases(['A\\Class', 'Another\\Class']));

        $this->assertTrue($spec->shouldProxy(uniqid()));

        $this->assertFalse($spec->shouldProxy('A\\Class'));
        $this->assertFalse($spec->shouldProxy('Another\\Class'));
    }

    /** @test */
    public function it_should_not_proxy_given_namespaces()
    {
        $spec = new ProxyNegator(new ProxyNamespace(['A\\Namespace', 'Another\\Namespace']));

        $this->assertTrue($spec->shouldProxy('A\\Class'));
        $this->assertTrue($spec->shouldProxy('Given\\A\\Namespace\\Class'));

        $this->assertFalse($spec->shouldProxy('A\\Namespace\\Class'));
        $this->assertFalse($spec->shouldProxy('Another\\Namespace\\Class'));
    }

    /** @test */
    public function it_should_work_as_a_nor()
    {
        $spec = new ProxyNegator(new ProxyCollection([
            new ProxyNamespace(['A\\Given\\Namespace']),
            new ProxyCases(['A\\Class\\Name']),
            new ProxyNegator(new ProxyByRegExp(['/^(foo)?b(a|ee)r$/']))
        ]));

        $this->assertTrue($spec->shouldProxy('beer'));
        $this->assertTrue($spec->shouldProxy('foobar'));
        $this->assertTrue($spec->shouldProxy('foobeer'));

        $this->assertFalse($spec->shouldProxy('A\\Given\\Namespace\\Class'));
        $this->assertFalse($spec->shouldProxy('A\\Class\\Name'));
    }
}
