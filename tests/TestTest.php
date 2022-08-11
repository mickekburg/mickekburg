<?php


use PHPUnit\Framework\TestCase;

class TestTest extends TestCase
{
    public function returnOneProvider()
    {
        return [
            'null' => [0, 555],
            'one' => [1, 1],
            'two' => [2, 2],
        ];
    }

    /**
     * @dataProvider returnOneProvider
     */
    public function testReturnOne($input, $good)
    {
        $test = (new Test())->returnOne($input);
        $this->assertSame($good, $test);
    }
}
