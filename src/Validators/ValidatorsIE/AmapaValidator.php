<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class AmapaValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual do Amapá é válida.
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_AP.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        // A IE do Amapá deve ter 9 dígitos.
        if (strlen($ie) !== 9) {
            return false;
        }

        // Os dois primeiros dígitos devem ser "03"
        if (substr($ie, 0, 2) !== '03') {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo do dígito verificador conforme a regra do Amapá.
     *
     * Utiliza os 8 primeiros dígitos multiplicados pelos pesos de 9 a 2, em ordem,
     * para calcular o dígito verificador:
     *  - Soma o produto dos dígitos pelos seus respectivos pesos;
     *  - Calcula o resto da divisão dessa soma por 11;
     *  - Se o resto for menor que 2, o dígito verificador é 0; caso contrário, é 11 - resto.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se o dígito verificador estiver correto.
     */
    private function calculate(string $ie): bool
    {
        $weights = [9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        for ($i = 0; $i < 8; $i++) {
            $sum += intval($ie[$i]) * $weights[$i];
        }

        $remainder = $sum % 11;
        $checkDigit = ($remainder < 2) ? 0 : (11 - $remainder);

        return $checkDigit === intval($ie[8]);
    }
}
