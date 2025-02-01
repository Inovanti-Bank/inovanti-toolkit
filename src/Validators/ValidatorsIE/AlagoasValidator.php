<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class AlagoasValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual de Alagoas é válida.
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_MT.html
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
     * Realiza o cálculo do dígito verificador conforme a regra de Alagoas.
     *
     * @param  string  $ie  Inscrição Estadual sanitizada (apenas números)
     * @return bool Retorna true se o dígito verificador estiver correto.
     */
    private function calculate(string $ie): bool
    {
        $weights = [2, 3, 4, 5, 6, 7, 8, 9];
        $sum = 0;

        for ($i = 0; $i < 8; $i++) {
            $sum += intval($ie[$i]) * $weights[$i];
        }

        $remainder = $sum % 11;
        $checkDigit = ($remainder === 10) ? 0 : $remainder;

        return $checkDigit === intval($ie[8]);
    }
}
