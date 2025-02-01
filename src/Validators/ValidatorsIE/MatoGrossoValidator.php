<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class MatoGrossoValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual do Mato Grosso é válida.
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_MT.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        // A IE do Mato Grosso deve ter 11 dígitos.
        if (strlen($ie) !== 11) {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo dos três dígitos verificadores para a IE do Mato Grosso.
     *
     * Calcula o DV1 usando os 8 primeiros dígitos com os pesos [3,2,9,8,7,6,5,4,3,2].
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se os dígitos verificadores estiverem corretos.
     */
    private function calculate(string $ie): bool
    {
        $weights = [3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $ieBody = substr($ie, 0, -1);
        $sum = $this->calculateWeightedSum($ieBody, $weights);

        $checkDigit = $this->calculateDigit($sum);

        return $checkDigit === (int) $ie[-1];
    }

    /**
     * Calcula a soma ponderada dos dígitos do corpo da IE.
     */
    private function calculateWeightedSum(string $ieBody, array $weights): int
    {
        $sum = 0;

        foreach (str_split($ieBody) as $index => $digit) {
            $sum += $digit * $weights[$index];
        }

        return $sum;
    }

    /**
     * Calcula o dígito verificador com base na soma ponderada.
     */
    private function calculateDigit(int $sum): int
    {
        $remainder = $sum % 11;
        $checkDigit = 11 - $remainder;

        return $checkDigit >= 10 ? 0 : $checkDigit;
    }
}
