<?php namespace Proxyvel\Specifications;

class ProxyByRegExpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @type ProxyByRegExp
     */
    private $spec;

    public function setUp()
    {
        $this->spec = new ProxyByRegExp();
    }

    /** @test */
    public function it_should_match_a_simple_regexp_to_a_string()
    {
        $this->spec->addRegExp('/foo/');
        $this->assertTrue($this->spec->shouldProxy('foo'));

        $this->assertFalse($this->spec->shouldProxy('bar'));
    }

    /** @test */
    public function it_should_match_a_regexp_to_a_string()
    {
        $this->spec->addRegExp('/f[aeiou]o/');
        $this->assertTrue($this->spec->shouldProxy('fao'));
        $this->assertTrue($this->spec->shouldProxy('feo'));
        $this->assertTrue($this->spec->shouldProxy('fio'));
        $this->assertTrue($this->spec->shouldProxy('foo'));
        $this->assertTrue($this->spec->shouldProxy('fuo'));

        $this->assertFalse($this->spec->shouldProxy('bar'));
    }

    /** @test */
    public function it_should_try_to_match_multiple_regexps_to_a_string()
    {
        // Feels like I'm just testing implementation here...
        $this->spec->addRegExp('/f[aeiou]o/');
        $this->spec->addRegExp('/ba[rz]/');
        $this->spec->addRegExp('/^lar(a)?vel$/');

        $this->assertTrue($this->spec->shouldProxy('fao'));
        $this->assertTrue($this->spec->shouldProxy('feo'));
        $this->assertTrue($this->spec->shouldProxy('fio'));
        $this->assertTrue($this->spec->shouldProxy('foo'));
        $this->assertTrue($this->spec->shouldProxy('fuo'));
        $this->assertTrue($this->spec->shouldProxy('bar'));
        $this->assertTrue($this->spec->shouldProxy('baz'));
        $this->assertTrue($this->spec->shouldProxy('foobar'));
        $this->assertTrue($this->spec->shouldProxy('laravel'));
        $this->assertTrue($this->spec->shouldProxy('larvel'));

        $this->assertFalse($this->spec->shouldProxy('Laravel'));
        $this->assertFalse($this->spec->shouldProxy('fro'));
        $this->assertFalse($this->spec->shouldProxy('fro'));
        $this->assertFalse($this->spec->shouldProxy('aravel'));
        $this->assertFalse($this->spec->shouldProxy('arave'));
    }
}