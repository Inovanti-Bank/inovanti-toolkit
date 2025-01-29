<?php

namespace Tests\Unit;

use InovantiBank\Toolkit\Helpers\StringHelper;
use InvalidArgumentException;
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

    public function test_generate_password()
    {
        // Gera uma senha padrão e verifica o tamanho
        $password = $this->stringHelper->generatePassword();
        $this->assertGreaterThanOrEqual(8, strlen($password));
        $this->assertLessThanOrEqual(32, strlen($password));

        // Testa a geração com apenas letras maiúsculas e caracteres especiais
        $password = $this->stringHelper->generatePassword(12, 20, true, false, false, true, false, '');
        $this->assertMatchesRegularExpression('/^[A-Z!@#$%^&*()-_+=<>?]+$/', $password);
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);
        $this->assertMatchesRegularExpression('/[!@#$%^&*]/', $password);

        // Testa a geração com tamanho máximo fixo
        $password = $this->stringHelper->generatePassword(8, 32, true, true, true, true, true);
        $this->assertSame(32, strlen($password));

        // Testa senha sem letras e caracteres especiais específicos
        $password = $this->stringHelper->generatePassword(12, 20, false, false, true, true, false, '()-_+=<>');
        $this->assertMatchesRegularExpression('/^[0-9!@#$%^&*?]+$/', $password);
        $this->assertMatchesRegularExpression('/[0-9]/', $password);
        $this->assertMatchesRegularExpression('/[!@#$%^&*]/', $password);

        // Testa senha contendo apenas números
        $password = $this->stringHelper->generatePassword(10, 10, false, false, true, false);
        $this->assertMatchesRegularExpression('/^[0-9]+$/', $password);

        // Testa se caracteres proibidos estão sendo removidos
        $password = $this->stringHelper->generatePassword(15, 15, true, true, true, true, false, '()');
        $this->assertStringNotContainsString('(', $password);
        $this->assertStringNotContainsString(')', $password);

        // Testa a exceção ao não permitir nenhum tipo de caractere
        $this->expectException(InvalidArgumentException::class);
        $this->stringHelper->generatePassword(10, 10, false, false, false, false);
    }
}
