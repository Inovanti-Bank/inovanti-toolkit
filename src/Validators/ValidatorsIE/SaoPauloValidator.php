<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class SaoPauloValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual de São Paulo é válida.
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_SP.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        if (strlen($ie) !== 12) {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo dos dígitos verificadores para a IE de São Paulo.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se os dígitos verificadores calculados forem iguais aos respectivos dígitos da IE.
     */
    private function calculate(string $ie): bool
    {
        $firstDigit = $this->calculateFirstDigit($ie);
        $secondDigit = $this->calculateSecondDigit($ie);

        return $firstDigit == (int) $ie[8] && $secondDigit == (int) $ie[11];
    }

    /**
     * Cálculo do primeiro dígito verificador.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return int Primeiro dígito verificador
     */
    private function calculateFirstDigit(string $ie): int
    {
        $weights = [1, 3, 4, 5, 6, 7, 8, 10];
        $body = substr($ie, 0, 8);
        $sum = 0;

        foreach (str_split($body) as $index => $digit) {
            $sum += $digit * $weights[$index];
        }

        $remainder = $sum % 11;
        $checkDigit = $remainder == 10 ? 0 : $remainder;

        return $checkDigit;
    }

    /**
     * Cálculo do segundo dígito verificador.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return int Segundo dígito verificador
     */
    private function calculateSecondDigit(string $ie): int
    {
        $weights = [3, 2, 10, 9, 8, 7, 6, 5, 4, 3, 2];
        $body = substr($ie, 0, 11);
        $sum = 0;

        foreach (str_split($body) as $index => $digit) {
            $sum += $digit * $weights[$index];
        }

        $remainder = $sum % 11;
        $checkDigit = $remainder == 10 ? 0 : $remainder;

        return $checkDigit;
    }
}
