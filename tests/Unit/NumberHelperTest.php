<?php

namespace Tests\Unit;

use InovantiBank\Toolkit\Helpers\NumberHelper;
use PHPUnit\Framework\TestCase;

class NumberHelperTest extends TestCase
{
    protected NumberHelper $numberHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->numberHelper = new NumberHelper;
    }

    public function test_formats_currency_correctly()
    {
        $this->assertSame('R$ 1.234,56', $this->numberHelper->formatCurrency(1234.56));
        $this->assertSame('USD 9.876,50', $this->numberHelper->formatCurrency(9876.50, 'USD'));
        $this->assertSame('€ 500,00', $this->numberHelper->formatCurrency(500.00, '€'));
    }

    public function test_pads_zero_correctly()
    {
        $this->assertSame('00042', $this->numberHelper->padZero(42, 5));
        $this->assertSame('000001', $this->numberHelper->padZero(1, 6));
        $this->assertSame('100', $this->numberHelper->padZero(100, 3));
    }

    public function test_converts_number_to_words_correctly()
    {
        $this->assertSame('cento e vinte e três reais e quarenta e cinco centavos', $this->numberHelper->numberToWords(123.45));
        $this->assertSame('dois mil reais', $this->numberHelper->numberToWords(2000));
        $this->assertSame('zero reais', $this->numberHelper->numberToWords(0));
        $this->assertSame('três milhões e quatrocentos e cinquenta e seis mil e setecentos e oitenta e nove reais e noventa e nove centavos', $this->numberHelper->numberToWords(3456789.99));
    }

    public function test_converts_number_to_words_without_currency()
    {
        $this->assertSame('cento e vinte e três e quarenta e cinco', $this->numberHelper->numberToWords(123.45, false));
        $this->assertSame('dois mil', $this->numberHelper->numberToWords(2000, false));
        $this->assertSame('zero', $this->numberHelper->numberToWords(0, false));
    }

    public function test_formats_percentage_correctly()
    {
        $this->assertSame('12,34%', $this->numberHelper->formatPercentage(0.1234));
        $this->assertSame('99,99%', $this->numberHelper->formatPercentage(0.9999, 2));
        $this->assertSame('45,678%', $this->numberHelper->formatPercentage(0.45678, 3));
    }
}
