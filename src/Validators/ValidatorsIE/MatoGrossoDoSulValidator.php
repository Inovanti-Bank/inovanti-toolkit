<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class MatoGrossoDoSulValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual do Mato Grosso do Sul é válida,
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_MS.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        // A IE do Mato Grosso do Sul deve ter 9 dígitos.
        if (strlen($ie) !== 9) {
            return false;
        }

        // Verifica se os dois primeiros dígitos são "28"
        if (substr($ie, 0, 2) !== '28') {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo do dígito verificador para a IE do Mato Grosso do Sul.
     *
     * Multiplica os 8 primeiros dígitos pelos pesos [9, 8, 7, 6, 5, 4, 3, 2],
     * soma os resultados e calcula o dígito verificador:
     *  - Se o resto da divisão da soma por 11 for menor que 2, o dígito verificador é 0;
     *  - Caso contrário, é 11 menos o resto.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se o dígito verificador calculado for igual ao nono dígito da IE.
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
