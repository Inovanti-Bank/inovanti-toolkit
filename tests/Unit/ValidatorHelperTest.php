<?php

namespace Tests\Unit;

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
}
