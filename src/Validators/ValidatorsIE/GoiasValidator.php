<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class GoiasValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual de Goiás é válida.
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_GO.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        // A IE de Goiás deve ter exatamente 9 dígitos.
        if (strlen($ie) !== 9) {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo do dígito verificador para a IE de Goiás.
     *
     * Utiliza os 8 primeiros dígitos multiplicados pelos pesos [9, 8, 7, 6, 5, 4, 3, 2].
     * Em seguida:
     *  - Soma os produtos;
     *  - Calcula o resto da divisão da soma por 11;
     *  - Se o resto for menor que 2, o dígito verificador é 0; caso contrário, é 11 - resto.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se o dígito verificador calculado for igual ao último dígito da IE.
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
