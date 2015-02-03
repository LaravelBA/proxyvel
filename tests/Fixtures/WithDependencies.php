<?php namespace Tests\Fixtures;

class WithDependencies
{
    private $testClass;

    function __construct(TestClass $testClass)
    {
        $this->testClass = $testClass;
    }

    /**
     * @return \Tests\Fixtures\TestClass
     */
    public function getTestClass()
    {
        return $this->testClass;
    }
}