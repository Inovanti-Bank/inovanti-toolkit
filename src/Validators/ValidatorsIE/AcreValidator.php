<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class AcreValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual do Acre é válida.
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_AC.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        $valid = true;

        if (strlen($ie) != 13) {
            $valid = false;
        }
        if ($valid && substr($ie, 0, 2) != '01') {
            $valid = false;
        }
        if ($valid && ! self::calculate($ie)) {
            $valid = false;
        }

        return $valid;
    }

    /**
     * Realiza o cálculo do dígito verificador conforme a regra de Acre.
     *
     * @param  string  $ie  Inscrição Estadual sanitizada (apenas números)
     * @return bool Retorna true se o dígito verificador estiver correto.
     */
    private function calculate(string $ie)
    {
        $weights1 = [4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 11; $i++) {
            $sum += intval($ie[$i]) * $weights1[$i];
        }
        $remainder = $sum % 11;
        $dv1 = ($remainder < 2) ? 0 : 11 - $remainder;

        if ($dv1 !== intval($ie[11])) {
            return false;
        }

        $weights2 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 11; $i++) {
            $sum += intval($ie[$i]) * $weights2[$i];
        }

        $sum += $dv1 * $weights2[11];
        $remainder = $sum % 11;
        $dv2 = ($remainder < 2) ? 0 : 11 - $remainder;

        return $dv2 === intval($ie[12]);
    }
}
