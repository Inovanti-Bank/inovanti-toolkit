<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class DistritoFederalValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual do Distrito Federal é válida.
     * conforme a regra:  http://www.sintegra.gov.br/Cad_Estados/cad_DF.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        // A IE do Distrito Federal deve ter 13 dígitos.
        if (strlen($ie) !== 13) {
            return false;
        }

        // Os dois primeiros dígitos devem ser "07"
        if (substr($ie, 0, 2) !== '07') {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo dos dígitos verificadores para a IE do Distrito Federal.
     *
     * Primeiro dígito:
     * - Utiliza os 11 primeiros dígitos com os pesos [4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2].
     * - Se o resto da divisão da soma por 11 for menor que 2, o dígito é 0; caso contrário, 11 menos o resto.
     *
     * Segundo dígito:
     * - Utiliza os 11 primeiros dígitos e o primeiro dígito verificador com os pesos [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2].
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se os dígitos verificadores estiverem corretos.
     */
    private function calculate(string $ie): bool
    {
        // Cálculo do primeiro dígito verificador (DV1)
        $weights1 = [4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 11; $i++) {
            $sum += intval($ie[$i]) * $weights1[$i];
        }
        $remainder = $sum % 11;
        $dv1 = ($remainder < 2) ? 0 : 11 - $remainder;

        // Verifica se o DV1 calculado confere com o 12º dígito da IE
        if ($dv1 !== intval($ie[11])) {
            return false;
        }

        // Cálculo do segundo dígito verificador (DV2)
        $weights2 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 11; $i++) {
            $sum += intval($ie[$i]) * $weights2[$i];
        }
        // Inclui o primeiro dígito verificador no cálculo
        $sum += $dv1 * $weights2[11];
        $remainder = $sum % 11;
        $dv2 = ($remainder < 2) ? 0 : 11 - $remainder;

        // Retorna true se o segundo dígito calculado for igual ao 13º dígito da IE
        return $dv2 === intval($ie[12]);
    }
}
