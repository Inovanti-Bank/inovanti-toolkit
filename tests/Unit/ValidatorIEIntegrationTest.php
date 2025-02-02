<?php

namespace Tests\Unit;

use InovantiBank\Toolkit\Enums\StateEnum;
use InovantiBank\Toolkit\Helpers\StringHelper;
use InovantiBank\Toolkit\Helpers\ValidatorHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ValidatorIEIntegrationTest extends TestCase
{
    protected ValidatorHelper $validatorHelper;

    protected function setUp(): void
    {
        $this->validatorHelper = new ValidatorHelper(new StringHelper);
    }

    #[DataProvider('providerIEData')]
    public function test_validates_ie(StateEnum $state, string $validIE, string $invalidIE)
    {
        $this->assertTrue(
            $this->validatorHelper->isValidIE($state, $validIE),
            "A IE válida para o estado {$state->name} não foi validada corretamente."
        );

        $this->assertFalse(
            $this->validatorHelper->isValidIE($state, $invalidIE),
            "A IE inválida para o estado {$state->name} foi validada como correta."
        );
    }

    public static function providerIEData(): array
    {
        return [
            'acre' => [StateEnum::AC, '01.908.446/863-89', '0190844686380'],
            'alagoas' => [StateEnum::AL, '248855409', '248855400'],
            'amapa' => [StateEnum::AP, '032213824', '032213820'],
            'amazonas' => [StateEnum::AM, '56.540.195-5', '565401950'],
            'baria' => [StateEnum::BA, '3403415-64', '340341560'],
            'ceara' => [StateEnum::CE, '73226834-6', '732268340'],
            'distrito_federal' => [StateEnum::DF, '07981464001-49', '0798146400140'],
            'espirito_santo' => [StateEnum::ES, '64010140-2', '640101400'],
            'goias' => [StateEnum::GO, '11.228.470-1', '112284700'],
            'maranhao' => [StateEnum::MA, '12916499-2', '129164990'],
            'mato_grosso' => [StateEnum::MT, '6406750953-0', '64067509531'],
            'mato_grosso_do_sul' => [StateEnum::MS, '28177629-6', '281776290'],
            'minas_gerais' => [StateEnum::MG, '174.766.542/5830', '1747665425831'],
            'para' => [StateEnum::PA, '15-769500-0', '157695001'],
            'paraiba' => [StateEnum::PB, '10356861-1', '103568610'],
            'parana' => [StateEnum::PR, '4508972569', '4508972560'],
            'pernambuco' => [StateEnum::PE, '955832624', '955832620'],
            'piaui' => [StateEnum::PI, '114514852', '114514850'],
            'rio_de_janeiro' => [StateEnum::RJ, '05.343.78-0', '05343781'],
            'rio_grande_do_norte' => [StateEnum::RN, '20.120.137-2', '201201370'],
            'rio_grande_do_sul' => [StateEnum::RS, '654/5207761', '6545207760'],
            'rondonia' => [StateEnum::RO, '24091852784061', '24091852784060'],
            'roraima' => [StateEnum::RR, '240945532', '240945530'],
            'santa_catarina' => [StateEnum::SC, '014.740.010', '014740011'],
            'sao_paulo' => [StateEnum::SP, '778.645.362.500', '778645362504'],
            'sergipe' => [StateEnum::SE, '706278062', '706278060'],
            'tocantins_9' => [StateEnum::TO, '95247853-6', '952478530'],
            'tocantins_11' => [StateEnum::TO, '9503247853-6', '95032478530'],
        ];
    }
}
