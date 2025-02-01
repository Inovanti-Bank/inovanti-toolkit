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
            [StateEnum::AC, '01.786.529/526-85', '5176527-61'],
            [StateEnum::AL, '248855409', '5176527061'],
            [StateEnum::AP, '032213824', '5176527061'],
            [StateEnum::AM, '56.540.195-5', '5176527061'],
            [StateEnum::BA, '3403415-64', '778.645.362.500'],
            [StateEnum::CE, '73226834-6', '5176527061'],
            [StateEnum::DF, '07981464001-49', '5176527061'],
            [StateEnum::ES, '64010140-2', '5176527061'],
            [StateEnum::GO, '11.228.470-1', '5176527061'],
            [StateEnum::MA, '12916499-2', '5176527061'],
            [StateEnum::MT, '6406750953-0', '5176527061'],
            [StateEnum::MS, '28177629-6', '5176527061'],
            [StateEnum::MG, '174.766.542/5830', '5176527061'],
            [StateEnum::PA, '15-769500-0', '5176527061'],
            [StateEnum::PB, '10356861-1', '5176527061'],
            [StateEnum::PR, '4508972569', '51765270610'],
            [StateEnum::PE, '955832624', '51765270610'],
            [StateEnum::PI, '114514852', '51765270610'],
            [StateEnum::RJ, '99640243', '51765270610'],
            [StateEnum::RN, '200627821', '51765270610'],
            [StateEnum::RS, '6760975913', '51765270610'],
            [StateEnum::RO, '24091852784061', '51765270610'],
            [StateEnum::RR, '240945532', '51765270610'],
            [StateEnum::SC, '014.740.010', '51765270610'],
            [StateEnum::SP, '778.645.362.500', '5176527-61'],
            [StateEnum::SE, '706278062', '51765270610'],
            [StateEnum::TO, '95247853-6', '51765270610'],
            [StateEnum::TO, '9503247853-6', '51765270610'],
        ];
    }
}
