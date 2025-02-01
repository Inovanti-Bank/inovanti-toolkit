<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class MinasGeraisValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual de Minas Gerais é válida,
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_MG.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        // A IE de Minas Gerais deve ter 13 dígitos.
        if (strlen($ie) !== 13) {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo dos dígitos verificadores para a IE de Minas Gerais.
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se os dígitos verificadores estiverem corretos.
     */
    private function calculate(string $ie): bool
    {
        $length = strlen($ie);
        $posFirstDigit = $length - 2;
        $posSecondDigit = $length - 1;

        $body = substr($ie, 0, 11);

        $firstDigit = self::calculateFirstDigit($body);
        $secondDigit = self::calculateSecondDigit($body.$firstDigit);

        return $firstDigit == $ie[$posFirstDigit] && $secondDigit == $ie[$posSecondDigit];
    }

    /**
     * Cálculo do primeiro dígito verificador.
     *
     * @param  string  $body  Inscrição Estadual sem os dois dígitos verificadores
     * @return int Dígito verificador
     */
    private static function calculateFirstDigit(string $body): int
    {
        // Inserir o algarismo zero "0" após o código do município
        $body = substr_replace($body, '0', 3, 0);
        $concatenation = '';
        foreach (str_split($body) as $i => $item) {
            // Peso é 1 para index ímpar e 2 para index par
            $weight = ((($i + 3) % 2) == 0) ? 2 : 1;
            $concatenation .= ($item * $weight);
        }
        $sum = 0;

        // Soma dos algarismos (não os produtos) do resultado obtido
        foreach (str_split($concatenation) as $digit) {
            $sum += $digit;
        }
        // Subtrai-se o resultado da soma da primeira dezena exata imediatamente superior
        $strSum = (string) $sum;
        $length = strlen($strSum);
        $lastChar = substr($strSum, $length - 1, 1);

        return ($lastChar == 0) ? 0 : (10 - $lastChar);
    }

    /**
     * Cálculo do segundo dígito verificador.
     *
     * @param  string  $body  Corpo da IE acrescido do primeiro dígito verificador correto
     * @return int Segundo dígito verificador
     */
    private static function calculateSecondDigit(string $body): int
    {
        $weight = 3;
        $sum = 0;
        foreach (str_split($body) as $item) {
            $sum += $item * $weight;
            $weight--;
            if ($weight == 1) {
                $weight = 11;
            }
        }

        $remainder = $sum % 11;
        $checkDigit = 11 - $remainder;

        return $checkDigit >= 10 ? 0 : $checkDigit;
    }
}
