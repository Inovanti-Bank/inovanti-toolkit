<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class SantaCatarinaValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual de Santa Catarina é válida.
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_SC.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        if (strlen($ie) !== 9) {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo do dígito verificador para a IE de Santa Catarina.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se o dígito verificador calculado for igual ao nono dígito da IE.
     */
    private function calculate(string $ie): bool
    {
        $sum = 0;
        $length = strlen($ie);
        $position = $length - 1;
        $weights = [9, 8, 7, 6, 5, 4, 3, 2, 1];
        $body = substr($ie, 0, $position);

        foreach (str_split($body) as $index => $digit) {
            $sum += $digit * $weights[$index];
        }

        $remainder = $sum % 11;
        $checkDigit = 11 - $remainder;

        if ($checkDigit === 11 || $checkDigit === 10) {
            $checkDigit = 0;
        }

        return $checkDigit == (int) $ie[$position];
    }
}
