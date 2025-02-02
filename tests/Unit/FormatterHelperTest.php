<?php

namespace Tests\Unit;

use Carbon\Carbon;
use InovantiBank\Toolkit\Enums\StateEnum;
use InovantiBank\Toolkit\Exceptions\InvalidFormatException;
use InovantiBank\Toolkit\Helpers\FormatterHelper;
use InovantiBank\Toolkit\Helpers\StringHelper;
use PHPUnit\Framework\Attributes\DataProvider;
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

    #[DataProvider('providerIEData')]
    public function test_formats_ie_correctly(StateEnum $state, string $formattedIE, string $formatIE)
    {
        $this->assertSame($formattedIE, $this->formatterHelper->formatIE($formatIE, $state));
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

    public static function providerIEData(): array
    {
        return [
            'acre' => [StateEnum::AC, '01.908.446/863-89', '0190844686389'],
            'alagoas' => [StateEnum::AL, '248855409', '248855409'],
            'amapa' => [StateEnum::AP, '032213824', '032213824'],
            'amazonas' => [StateEnum::AM, '56.540.195-5', '565401955'],
            'baria' => [StateEnum::BA, '3403415-64', '340341564'],
            'ceara' => [StateEnum::CE, '73226834-6', '732268346'],
            'distrito_federal' => [StateEnum::DF, '07981464001-49', '0798146400149'],
            'espirito_santo' => [StateEnum::ES, '64010140-2', '640101402'],
            'goias' => [StateEnum::GO, '11.228.470-1', '112284701'],
            'maranhao' => [StateEnum::MA, '12916499-2', '129164992'],
            'mato_grosso' => [StateEnum::MT, '6406750953-0', '64067509530'],
            'mato_grosso_do_sul' => [StateEnum::MS, '28177629-6', '281776296'],
            'minas_gerais' => [StateEnum::MG, '174.766.542/5830', '1747665425830'],
            'para' => [StateEnum::PA, '15-769500-0', '157695000'],
            'paraiba' => [StateEnum::PB, '10356861-1', '103568611'],
            'parana' => [StateEnum::PR, '4508972569', '4508972569'],
            'pernambuco' => [StateEnum::PE, '955832624', '955832624'],
            'piaui' => [StateEnum::PI, '114514852', '114514852'],
            'rio_de_janeiro' => [StateEnum::RJ, '05.343.78-0', '05343780'],
            'rio_grande_do_norte' => [StateEnum::RN, '20.120.137-2', '201201372'],
            'rio_grande_do_sul' => [StateEnum::RS, '654/5207761', '6545207761'],
            'rondonia' => [StateEnum::RO, '24091852784061', '24091852784061'],
            'roraima' => [StateEnum::RR, '240945532', '240945532'],
            'santa_catarina' => [StateEnum::SC, '014.740.010', '014740010'],
            'sao_paulo' => [StateEnum::SP, '778.645.362.500', '778645362500'],
            'sergipe' => [StateEnum::SE, '706278062', '706278062'],
            'tocantins_9' => [StateEnum::TO, '95247853-6', '952478536'], // Tocantins com 9 dígitos
            'tocantins_11' => [StateEnum::TO, '9503247853-6', '95032478536'], // Tocantins com 11 dígitos
        ];
    }
}
