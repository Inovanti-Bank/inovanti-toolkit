<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class RoraimaValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual de Roraima é válida.
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_RR.html
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
     * Realiza o cálculo do dígito verificador para a IE de Roraima.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se o dígito verificador calculado for igual ao nono dígito da IE.
     */
    private function calculate(string $ie): bool
    {
        $sum = 0;
        $length = strlen($ie);
        $position = $length - 1;
        $weights = [1, 2, 3, 4, 5, 6, 7, 8];
        $body = substr($ie, 0, $position);

        foreach (str_split($body) as $index => $digit) {
            $sum += $digit * $weights[$index];
        }

        $remainder = $sum % 9;

        return $remainder == (int) $ie[$position];
    }
}
