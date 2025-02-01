<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class RioDeJaneiroValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual do Rio de Janeiro é válida,
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_RJ.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        // A IE do Rio de Janeiro deve ter 8 dígitos.
        if (strlen($ie) !== 8) {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo do dígito verificador para a IE do Rio de Janeiro.
     *
     * Multiplica os 7 primeiros dígitos pelos pesos [2, 7, 6, 5, 4, 3, 2],
     * soma os resultados e calcula o dígito verificador:
     *  - Se o resto da divisão da soma por 11 for menor que 2, o dígito verificador é 0;
     *  - Caso contrário, é 11 menos o resto.
     *
     * O dígito calculado deve ser igual ao oitavo dígito da IE.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se o dígito verificador estiver correto.
     */
    private function calculate(string $ie): bool
    {
        $weights = [2, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        for ($i = 0; $i < 7; $i++) {
            $sum += intval($ie[$i]) * $weights[$i];
        }

        $remainder = $sum % 11;
        $checkDigit = ($remainder < 2) ? 0 : (11 - $remainder);

        return $checkDigit === intval($ie[7]);
    }
}
