<?php namespace Proxyvel\Specifications;

class ProxyCasesTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_test_for_exact_cases()
    {
        $spec = new ProxyCases([
            'A\\Class\\Name',
            'some-string',
            'Another\\Class'
        ]);

        $this->assertTrue($spec->shouldProxy('A\\Class\\Name'));
        $this->assertTrue($spec->shouldProxy('some-string'));
        $this->assertTrue($spec->shouldProxy('Another\\Class'));

        $this->assertFalse($spec->shouldProxy('somestring'));
        $this->assertFalse($spec->shouldProxy('Class\\Name'));
        $this->assertFalse($spec->shouldProxy('Class'));
    }
}
