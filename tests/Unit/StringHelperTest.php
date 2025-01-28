<?php

namespace Tests\Unit;

use InovantiBank\Toolkit\Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    protected StringHelper $stringHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stringHelper = new StringHelper;
    }

    public function test_formats_names_correctly()
    {
        $this->assertSame('João Ernesto da Silva e Souza', $this->stringHelper->formatName('JOÃO ERNESTO DA SILVA E SOUZA'));
        $this->assertSame('Ana Clara de Souza', $this->stringHelper->formatName('ANA CLARA DE SOUZA'));
    }

    public function test_abbreviates_names_correctly()
    {
        $this->assertSame('João E. da S. e Souza', $this->stringHelper->formatName('JOÃO ERNESTO DA SILVA E SOUZA', true));
        $this->assertSame('Ana C. de Souza', $this->stringHelper->formatName('ANA CLARA DE SOUZA', true));
    }

    public function test_returns_first_and_last_names_correctly()
    {
        $this->assertSame('João Souza', $this->stringHelper->formatName('JOÃO ERNESTO DA SILVA E SOUZA', false, true));
        $this->assertSame('Ana Souza', $this->stringHelper->formatName('ANA CLARA DE SOUZA', false, true));
    }

    public function test_limits_string_correctly()
    {
        $this->assertSame('Olá Mundo,...', $this->stringHelper->limitString('Olá Mundo, tudo bem?', 10));
        $this->assertSame('Olá...', $this->stringHelper->limitString('Olá Mundo', 3));
    }

    public function test_removes_accents_correctly()
    {
        $this->assertSame('Ola Mundo', $this->stringHelper->removeAccents('Olá Mundo'));
        $this->assertSame('Joao Ernesto da Silva', $this->stringHelper->removeAccents('João Ernesto da Silva'));
    }

    public function test_returns_only_numbers()
    {
        $this->assertSame('123456', $this->stringHelper->onlyNumbers('ABC 123 DEF 456'));
        $this->assertSame('0987654321', $this->stringHelper->onlyNumbers('(098) 765-4321'));
    }

    public function test_checks_if_string_is_palindrome()
    {
        $this->assertTrue($this->stringHelper->isPalindrome('Ana'));
        $this->assertTrue($this->stringHelper->isPalindrome('A base do teto desaba'));
        $this->assertFalse($this->stringHelper->isPalindrome('Olá Mundo'));
    }
}
