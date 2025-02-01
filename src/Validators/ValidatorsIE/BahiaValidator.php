<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class BahiaValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual da Bahia é válida.
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_BA.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        $length = strlen($ie);

        if ($length !== 8 && $length !== 9) {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo do dígito verificador para a IE da Bahia.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se o dígito verificador estiver correto.
     */
    private function calculate(string $ie): bool
    {
        $length = strlen($ie);

        if ($length === 8) {
            // Para IE com 8 dígitos, o primeiro dígito deve ser 6, 7 ou 9.
            if (! in_array($ie[0], ['6', '7', '9'])) {
                return false;
            }

            $weights = [7, 6, 5, 4, 3, 2, 1];
            $sum = 0;
            for ($i = 0; $i < 7; $i++) {
                $sum += intval($ie[$i]) * $weights[$i];
            }
            $remainder = $sum % 10;
            $checkDigit = ($remainder === 0) ? 0 : (10 - $remainder);

            return $checkDigit === intval($ie[7]);
        } elseif ($length === 9) {
            // Para IE com 9 dígitos, o primeiro dígito deve ser 0, 1, 2, 3, 4 ou 5.
            if (! in_array($ie[0], ['0', '1', '2', '3', '4', '5'])) {
                return false;
            }

            $weights = [8, 7, 6, 5, 4, 3, 2, 10];
            $sum = 0;
            for ($i = 0; $i < 8; $i++) {
                $sum += intval($ie[$i]) * $weights[$i];
            }
            $remainder = $sum % 10;
            $checkDigit = ($remainder === 0) ? 0 : (10 - $remainder);

            return $checkDigit === intval($ie[8]);
        }

        return false;
    }
}
