<?php

namespace Tests\Unit;

use Carbon\Carbon;
use InovantiBank\Toolkit\Exceptions\InvalidFormatException;
use InovantiBank\Toolkit\Helpers\FormatterHelper;
use InovantiBank\Toolkit\Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class FormatterHelperTest extends TestCase
{
    protected FormatterHelper $formatterHelper;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setLocale('pt_BR');
        date_default_timezone_set('America/Sao_Paulo');

        $stringHelper = new StringHelper;
        $this->formatterHelper = new FormatterHelper($stringHelper);
    }

    public function test_formats_cpf_correctly()
    {
        $this->assertSame('123.456.789-09', $this->formatterHelper->formatCpfCnpj('12345678909'));
        $this->assertSame('123.456.789-09', $this->formatterHelper->formatCpfCnpj('123.456.789-09'));
        $this->assertSame('987.654.321-00', $this->formatterHelper->formatCpfCnpj('98765432100'));
    }

    public function test_formats_cnpj_correctly()
    {
        $this->assertSame('12.345.678/0001-90', $this->formatterHelper->formatCpfCnpj('12345678000190'));
        $this->assertSame('12.345.678/0001-90', $this->formatterHelper->formatCpfCnpj('12.345.678/0001-90'));
        $this->assertSame('98.765.432/0001-00', $this->formatterHelper->formatCpfCnpj('98765432000100'));
    }

    public function test_throws_exception_for_invalid_formats()
    {
        $this->expectException(InvalidFormatException::class);
        $this->expectExceptionMessage('Invalid CPF/CNPJ format');

        $this->formatterHelper->formatCpfCnpj('12345');
    }

    public function test_formats_date_human_readable()
    {
        $this->assertSame('28 de janeiro de 2025', $this->formatterHelper->formatDateHuman('2025-01-28 14:01:23'));
    }

    public function test_formats_date_short_human()
    {
        $this->assertSame('28 de jan de 2025', $this->formatterHelper->formatDateShortHuman('2025-01-28 14:01:23'));
    }

    public function test_formats_datetime_human()
    {
        $this->assertSame('ter, 28 de jan de 2025, 14:01', $this->formatterHelper->formatDateTimeHuman('2025-01-28 14:01:23'));
    }

    public function test_formats_date_relative_past()
    {
        $this->assertSame('há 2 dias', $this->formatterHelper->formatDateRelative(now()->subDays(2)->toDateTimeString()));
    }

    public function test_formats_date_relative_future()
    {
        $this->assertSame('em 2 horas', $this->formatterHelper->formatDateRelative(now()->addHours(3)->toDateTimeString()));
    }

    public function test_formats_date_weekday()
    {
        $this->assertSame('terça-feira, 28 de janeiro de 2025', $this->formatterHelper->formatDateWeekday('2025-01-28 14:01:23'));
    }

    public function test_formats_custom_date()
    {
        $this->assertSame('28/01/2025 14:01', $this->formatterHelper->formatDateCustom('2025-01-28 14:01:23', 'd/m/Y H:i'));
    }
}
