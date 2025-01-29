<?php

namespace Tests\Unit;

use InovantiBank\Toolkit\Enums\StateEnum;
use InovantiBank\Toolkit\Exceptions\InvalidFormatException;
use InovantiBank\Toolkit\Helpers\StringHelper;
use InovantiBank\Toolkit\Helpers\ValidatorHelper;
use PHPUnit\Framework\TestCase;

class ValidatorHelperTest extends TestCase
{
    protected ValidatorHelper $validatorHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validatorHelper = new ValidatorHelper(new StringHelper);
    }

    public function teste_validates_cpf_correctly()
    {
        $this->assertTrue($this->validatorHelper->isValidCPF('212.427.350-70'));
        $this->assertTrue($this->validatorHelper->isValidCPF('04528791080'));
        $this->assertFalse($this->validatorHelper->isValidCPF('111.111.111-11'));
        $this->assertFalse($this->validatorHelper->isValidCPF('12345678900'));
    }

    public function teste_validates_cnpj_correctly()
    {
        $this->assertTrue($this->validatorHelper->isValidCNPJ('51.951.863/0001-85'));
        $this->assertTrue($this->validatorHelper->isValidCNPJ('96551284000183'));
        $this->assertFalse($this->validatorHelper->isValidCNPJ('00.000.000/0000-00'));
        $this->assertFalse($this->validatorHelper->isValidCNPJ('00000000000000'));
    }

    public function teste_validates_pis_correctly()
    {
        $this->assertTrue($this->validatorHelper->isValidPIS('756.75348.42-2'));
        $this->assertTrue($this->validatorHelper->isValidPIS('04126852475'));
        $this->assertFalse($this->validatorHelper->isValidPIS('000.00000.00-0'));
        $this->assertFalse($this->validatorHelper->isValidPIS('12345678901'));
    }

    public function teste_validates_email_correctly()
    {
        $this->assertTrue($this->validatorHelper->isValidEmail('test@example.com'));
        $this->assertFalse($this->validatorHelper->isValidEmail('invalid-email'));
        $this->assertFalse($this->validatorHelper->isValidEmail('user@invalid'));
    }

    public function teste_validates_date_correctly()
    {
        $this->assertTrue($this->validatorHelper->isValidDate('2024-02-01'));
        $this->assertFalse($this->validatorHelper->isValidDate('2024-13-01'));
        $this->assertTrue($this->validatorHelper->isValidDate('01/02/2024', 'd/m/Y'));
        $this->assertFalse($this->validatorHelper->isValidDate('32/01/2024', 'd/m/Y'));
    }

    public function teste_validates_cep_correctly()
    {
        $this->assertTrue($this->validatorHelper->isValidCEP('82630-490'));
        $this->assertFalse($this->validatorHelper->isValidCEP('12345678'));
        $this->assertFalse($this->validatorHelper->isValidCEP('abcde-xyz'));
    }

    public function teste_validates_credteste_card_correctly()
    {
        $this->assertTrue($this->validatorHelper->isValidCreditCard('5373 7680 0613 0975'));
        $this->assertFalse($this->validatorHelper->isValidCreditCard('1234-5678-1234-5678'));
        $this->assertFalse($this->validatorHelper->isValidCreditCard('1234567812345678'));
    }

    public function teste_validates_title_correctly()
    {
        $this->assertTrue($this->validatorHelper->isValidTitle('771 33114 0620'));
        $this->assertFalse($this->validatorHelper->isValidTitle('123 45678 9012'));
    }

    public function teste_validates_renavam_correctly()
    {
        $this->assertTrue($this->validatorHelper->isValidRENAVAM('85885386557'));
        $this->assertTrue($this->validatorHelper->isValidRENAVAM('97594295877'));
        $this->assertTrue($this->validatorHelper->isValidRENAVAM('82495101316'));
        $this->assertFalse($this->validatorHelper->isValidRENAVAM('00000000000'));
        $this->assertFalse($this->validatorHelper->isValidRENAVAM('12345678900'));
        $this->assertFalse($this->validatorHelper->isValidRENAVAM('11111111111'));
        $this->assertFalse($this->validatorHelper->isValidRENAVAM('1234567'));
        $this->assertFalse($this->validatorHelper->isValidRENAVAM('123456789012'));
    }

    public function teste_validates_document_type()
    {
        $this->assertTrue($this->validatorHelper->validateDocument('11144477735'));
        $this->assertTrue($this->validatorHelper->validateDocument('12344304000155'));
        $this->expectException(InvalidFormatException::class);
        $this->validatorHelper->validateDocument('123456');
    }

    public function teste_validates_cnh()
    {
        $this->assertTrue($this->validatorHelper->isValidCNH('76628613510'));
        $this->assertFalse($this->validatorHelper->isValidCNH('76628613511'));
    }

    public function teste_validates_ie()
    {
        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::AC, '01.786.529/526-85'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::AC, '5176527-61'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::AL, '248855409'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::AL, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::AP, '032213824'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::AP, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::AM, '56.540.195-5'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::AM, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::BA, '3403415-64'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::BA, '778.645.362.500'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::CE, '73226834-6'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::CE, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::DF, '07981464001-49'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::DF, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::ES, '64010140-2'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::ES, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::GO, '11.228.470-1'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::GO, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::MA, '12916499-2'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::MA, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::MT, '4431457227-0'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::MT, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::MS, '28177629-6'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::MS, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::MG, '339.884.782/1475'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::MG, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::PA, '15-769500-0'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::PA, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::PB, '10356861-1'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::PB, '5176527061'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::PR, '4508972569'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::PR, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::PE, '955832624'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::PE, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::PI, '114514852'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::PI, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::RJ, '99640243'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::RJ, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::RN, '200627821'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::RN, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::RS, '6760975913'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::RS, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::RO, '24091852784061'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::RO, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::RR, '240945532'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::RR, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::SC, '731062094'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::SC, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::SP, '778.645.362.500'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::SP, '5176527-61'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::SE, '706278062'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::SE, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::TO9, '032456204'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::TO9, '51765270610'));

        $this->assertTrue($this->validatorHelper->isValidIE(StateEnum::TO11, '03032456204'));
        $this->assertFalse($this->validatorHelper->isValidIE(StateEnum::TO11, '5176527061'));
    }
}
