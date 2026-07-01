<?php

namespace InovantiBank\Toolkit\Helpers;

use Carbon\Carbon;
use InovantiBank\Toolkit\Enums\StateEnum;
use InovantiBank\Toolkit\Exceptions\InvalidFormatException;

class ValidatorHelper
{
    public function __construct(protected StringHelper $strHelper) {}

    public function validateDocument(string $document, bool $allowAlphanumericCnpj = true): bool|string
    {
        $document = $allowAlphanumericCnpj 
            ? $this->strHelper->onlyAlphanumeric($document, true) 
            : $this->strHelper->onlyNumbers($document);

        return match (strlen($document)) {
            11 => $this->isValidCPF($document),
            14 => $this->isValidCNPJ($document, $allowAlphanumericCnpj),
            default => throw new InvalidFormatException('Documento inválido. CPF deve ter 11 dígitos e CNPJ deve ter 14 dígitos.')
        };
    }

    public function isValidCPF(string $cpf): bool
    {
        $cpf = $this->strHelper->onlyNumbers($cpf);

        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $sum = 0;
            for ($i = 0; $i < $t; $i++) {
                $sum += $cpf[$i] * (($t + 1) - $i);
            }
            $digit = ((10 * $sum) % 11) % 10;
            if ($cpf[$t] != $digit) {
                return false;
            }
        }

        return true;
    }

    public function isValidCNPJ(string $cnpj, bool $allowAlphanumeric = false): bool
    {
        $cnpj = $allowAlphanumeric 
            ? $this->strHelper->onlyAlphanumeric($cnpj, true) 
            : $this->strHelper->onlyNumbers($cnpj);

        if (strlen($cnpj) !== 14 || preg_match('/^(.)\1{13}$/', $cnpj)) {
            return false;
        }

        if (!is_numeric(substr($cnpj, 12, 2))) {
            return false;
        }

        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $val = ord($cnpj[$i]) - 48; 
            $sum += $val * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        if ($cnpj[12] != ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }

        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $val = ord($cnpj[$i]) - 48; 
            $sum += $val * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        return $cnpj[13] == ($rest < 2 ? 0 : 11 - $rest);
    }

    public function isValidRG(string $rg, ?string $state = null): bool
    {
        $rg = $this->strHelper->onlyNumbers($rg);
        // TODO: Procurando documentação do atual RG para cada estado
    }

    public function isValidCIN(string $cin): bool
    {
        $cin = $this->strHelper->onlyNumbers($cin);
        // TODO: Procurando documentação do novo RG
    }

    public function isValidPIS(string $pis): bool
    {
        $pis = $this->strHelper->onlyNumbers($pis);

        if (strlen($pis) !== 11 || preg_match('/(\d)\1{10}/', $pis)) {
            return false;
        }

        $weights = [3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        for ($i = 0; $i < 10; $i++) {
            $sum += $pis[$i] * $weights[$i];
        }

        $remainder = $sum % 11;
        $digit = ($remainder < 2) ? 0 : 11 - $remainder;

        return $pis[10] == $digit;
    }

    public function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isValidDate(string $date, string $format = 'Y-m-d'): bool
    {
        $parsedDate = Carbon::createFromFormat($format, $date);

        return $parsedDate && $parsedDate->format($format) === $date;
    }

    public function isValidCEP(string $cep): bool
    {
        return preg_match('/^\d{5}-\d{3}$/', $cep) === 1;
    }

    public function isValidCreditCard(string $number): bool
    {
        return preg_match('/^\d{4} \d{4} \d{4} \d{4}$/', $number) === 1;
    }

    public function isValidTitle(string $title): bool
    {
        $title = str_pad(preg_replace('/\D/', '', $title), 12, '0', STR_PAD_LEFT);

        $state = intval(substr($title, 8, 2));

        if (strlen($title) !== 12 || $state < 1 || $state > 28) {
            return false;
        }

        $d = 0;
        for ($i = 0; $i < 8; $i++) {
            $d += $title[$i] * (9 - $i);
        }
        $d %= 11;
        $d = ($d < 2) ? 0 : 11 - $d;

        if ($title[10] != $d) {
            return false;
        }

        $d *= 2;
        for ($i = 8; $i < 10; $i++) {
            $d += $title[$i] * (12 - $i);
        }
        $d %= 11;
        $d = ($d < 2) ? 0 : 11 - $d;

        return $title[11] == $d;
    }

    public function isValidRENAVAM(string $renavam): bool
    {
        $renavam = $this->strHelper->onlyNumbers($renavam);

        // O RENAVAM deve ter 9 ou 11 dígitos
        if (! in_array(strlen($renavam), [9, 11])) {
            return false;
        }

        // Se for do formato antigo (9 dígitos), preencher com zeros à esquerda
        if (strlen($renavam) === 9) {
            $renavam = '00'.$renavam;
        }

        // Verificar se é uma sequência inválida (00000000000 ou todos números iguais)
        if (preg_match('/^(\d)\1{10}$/', $renavam)) {
            return false;
        }

        // Pegamos os 10 primeiros números e separamos o último dígito verificador
        $renavamSemDigito = substr($renavam, 0, 10);
        $digitoVerificador = (int) $renavam[10];

        $multiplicadores = [3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;

        for ($i = 0; $i < 10; $i++) {
            $soma += (int) $renavamSemDigito[$i] * $multiplicadores[$i];
        }

        // Cálculo do módulo 11
        $resto = $soma % 11;
        $digitoCalculado = ($resto == 10 || $resto == 11) ? 0 : (11 - $resto);

        return $digitoCalculado === $digitoVerificador;
    }

    public function isValidCNH(string $cnh): bool
    {
        $cnh = $this->strHelper->onlyNumbers($cnh);

        if (strlen($cnh) != 11 || preg_match('/(\d)\1{10}/', $cnh)) {
            return false;
        }

        $dsc = 0;
        for ($i = 0, $j = 9; $i < 9; $i++, $j--) {
            $dsc += $cnh[$i] * $j;
        }

        $dv1 = $dsc % 11;
        $dv1 = ($dv1 > 9) ? 0 : $dv1;

        if ($cnh[9] != $dv1) {
            return false;
        }

        $dsc = 0;
        for ($i = 0, $j = 1; $i < 9; $i++, $j++) {
            $dsc += $cnh[$i] * $j;
        }

        $dv2 = $dsc % 11;
        $dv2 = ($dv2 > 9) ? 0 : $dv2;

        return $cnh[10] == $dv2;
    }

    /**
     * Valida a Inscrição Estadual de um estado específico.
     *
     * @param  StateEnum  $state  Estado da IE
     * @param  string  $number  Número da Inscrição Estadual
     * @return bool Retorna verdadeiro se for válida, falso caso contrário
     */
    public function isValidIE(StateEnum $state, string $number): bool
    {
        $number = $this->strHelper->onlyNumbers($number);

        return strlen($number) === $state->getIEDigitLength();
    }
}
