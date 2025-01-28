<?php

namespace Tests\Unit;

use Carbon\Carbon;
use InovantiBank\Toolkit\Helpers\DateHelper;
use PHPUnit\Framework\TestCase;

class DateHelperTest extends TestCase
{
    protected DateHelper $dateHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dateHelper = new DateHelper;
    }

    public function test_formats_a_date_correctly()
    {
        $this->assertSame('15/08/2023', $this->dateHelper->formatDate('2023-08-15'));
        $this->assertSame('2023-08-15', $this->dateHelper->formatDate('15/08/2023', 'd/m/Y', 'Y-m-d'));
    }

    public function test_adds_business_days_correctly()
    {
        Carbon::setTestNow('2023-08-11');
        $this->assertSame('2023-08-16', $this->dateHelper->addBusinessDays('2023-08-11', 3));

        Carbon::setTestNow('2023-08-14');
        $this->assertSame('2023-08-17', $this->dateHelper->addBusinessDays('2023-08-14', 3));

        Carbon::setTestNow(null);
    }
}
