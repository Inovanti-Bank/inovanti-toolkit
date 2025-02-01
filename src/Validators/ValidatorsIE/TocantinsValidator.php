<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class TocantinsValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual de Tocantins é válida.
     * conforme a regra :http://www.sintegra.gov.br/Cad_Estados/cad_TO.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        return $this->validateOldFormat($ie) || $this->validateNewFormat($ie);
    }

    /**
     * Verifica se a inscrição estadual é válida para Tocantins (TO) seguindo a regra antiga.
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool true se a IE for válida, false caso contrário.
     */
    protected function validateOldFormat(string $ie): bool
    {
        if (strlen($ie) !== 11) {
            return false;
        }

        $categoryCode = substr($ie, 2, 2);
        if (! in_array($categoryCode, ['01', '02', '03', '99'])) {
            return false;
        }

        $core = substr_replace($ie, '', 2, 2);

        return $this->computeOldDigit($core);
    }

    /**
     * Verifica se a inscrição estadual é válida para Tocantins (TO) seguindo a nova regra.
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool true se a IE for válida, false caso contrário.
     */
    protected function validateNewFormat(string $ie): bool
    {
        return strlen($ie) === 9 && $this->computeNewDigit($ie);
    }

    /**
     * Valida o dígito da inscrição estadual de Tocantins seguindo a regra antiga.
     *
     * @param  string  $ie  Inscrição Estadual sem a categoria
     * @return bool true se o dígito for válido, false caso contrário.
     */
    protected function computeOldDigit(string $ieCore): bool
    {
        $weight = 9;
        $totalSum = 0;
        $length = strlen($ieCore);
        $position = $length - 1;
        $body = substr($ieCore, 0, $length - 1);

        foreach (str_split($body) as $digit) {
            $totalSum += $digit * $weight;
            $weight--;
        }

        $remainder = $totalSum % 11;
        $checkDigit = 11 - $remainder;
        if ($remainder < 2) {
            $checkDigit = 0;
        }

        return $checkDigit == (int) $ieCore[$position];
    }

    /**
     * Valida o dígito da inscrição estadual de Tocantins seguindo a nova regra.
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool true se o dígito for válido, false caso contrário.
     */
    protected function computeNewDigit(string $ie): bool
    {
        $weight = 9;
        $totalSum = 0;
        $length = strlen($ie);
        $position = $length - 1;
        $body = substr($ie, 0, $length - 1);

        foreach (str_split($body) as $digit) {
            $totalSum += $digit * $weight;
            $weight--;
        }

        $remainder = $totalSum % 11;
        $checkDigit = 11 - $remainder;
        if ($remainder < 2) {
            $checkDigit = 0;
        }

        return $checkDigit == (int) $ie[$position];
    }
}
