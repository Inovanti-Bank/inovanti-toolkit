<?php

namespace Tests\Unit;

use InovantiBank\Toolkit\Helpers\ArrayHelper;
use PHPUnit\Framework\TestCase;

class ArrayHelperTest extends TestCase
{
    protected ArrayHelper $arrayHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->arrayHelper = new ArrayHelper;
    }

    public function test_removes_duplicates_from_an_array()
    {
        $array = [1, 2, 2, 3, 4, 4, 5];
        $expected = [1, 2, 3, 4, 5];

        $this->assertSame($expected, $this->arrayHelper->removeDuplicates($array));
    }

    public function test_checks_if_an_array_is_associative()
    {
        $associativeArray = ['name' => 'John', 'age' => 30];
        $sequentialArray = [1, 2, 3, 4];

        $this->assertTrue($this->arrayHelper->isAssociative($associativeArray));
        $this->assertFalse($this->arrayHelper->isAssociative($sequentialArray));
    }

    public function test_converts_an_array_to_query_string()
    {
        $data = ['name' => 'John Doe', 'age' => 30, 'city' => 'São Paulo'];
        $expected = 'name=John+Doe&age=30&city=S%C3%A3o+Paulo';

        $this->assertSame($expected, $this->arrayHelper->toQueryString($data));
    }
}
