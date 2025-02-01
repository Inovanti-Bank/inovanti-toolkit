<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class RioGrandeDoSulValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual do Rio Grande do Sul é válida,
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_RS.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        // A IE do Rio Grande do Sul deve ter 10 dígitos.
        if (strlen($ie) !== 10) {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo do dígito verificador para a IE do Rio Grande do Sul.
     *
     * Multiplica os 9 primeiros dígitos pelos pesos [2, 9, 8, 7, 6, 5, 4, 3, 2],
     * soma os resultados e calcula o dígito verificador:
     *  - Se o resto da divisão da soma por 11 for 0 ou 1, o dígito verificador é 0;
     *  - Caso contrário, é 11 menos o resto.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se o dígito verificador calculado for igual ao décimo dígito da IE.
     */
    private function calculate(string $ie): bool
    {
        $weights = [2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $sum += intval($ie[$i]) * $weights[$i];
        }

        $remainder = $sum % 11;
        $checkDigit = ($remainder === 0 || $remainder === 1) ? 0 : (11 - $remainder);

        return $checkDigit === intval($ie[9]);
    }
}
