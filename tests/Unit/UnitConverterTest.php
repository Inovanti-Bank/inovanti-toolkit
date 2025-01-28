<?php

namespace Tests\Unit;

use InovantiBank\Toolkit\Helpers\UnitConverter;
use PHPUnit\Framework\TestCase;

class UnitConverterTest extends TestCase
{
    protected UnitConverter $unitConverter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->unitConverter = new UnitConverter;
    }

    public function test_converts_bytes_to_human_readable_units()
    {
        $this->assertSame('1 B', $this->unitConverter->bytesToHumanReadable(1));
        $this->assertSame('1.00 KB', $this->unitConverter->bytesToHumanReadable(1024));
        $this->assertSame('1.00 MB', $this->unitConverter->bytesToHumanReadable(1048576));
        $this->assertSame('1.00 GB', $this->unitConverter->bytesToHumanReadable(1073741824));
        $this->assertSame('1.00 TB', $this->unitConverter->bytesToHumanReadable(1099511627776));
    }

    public function test_handles_large_numbers_correctly()
    {
        $this->assertSame('1.50 KB', $this->unitConverter->bytesToHumanReadable(1536));
        $this->assertSame('2.44 MB', $this->unitConverter->bytesToHumanReadable(2555904));
        $this->assertSame('3.81 GB', $this->unitConverter->bytesToHumanReadable(4094300000));
    }

    public function test_respects_custom_precision()
    {
        $this->assertSame('1.0 KB', $this->unitConverter->bytesToHumanReadable(1024, 1));
        $this->assertSame('1.000 MB', $this->unitConverter->bytesToHumanReadable(1048576, 3));
        $this->assertSame('1 TB', $this->unitConverter->bytesToHumanReadable(1099511627776, 0));
    }
}
