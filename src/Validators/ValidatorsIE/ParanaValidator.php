<?php

namespace InovantiBank\Toolkit\Validators\ValidatorsIE;

use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;

class ParanaValidator implements ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual do Paraná é válida,
     * conforme a regra: http://www.sintegra.gov.br/Cad_Estados/cad_PR.html
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se a IE for válida, false caso contrário.
     */
    public function isValid(string $ie): bool
    {
        // A IE do Paraná deve ter 10 dígitos.
        if (strlen($ie) !== 10) {
            return false;
        }

        return $this->calculate($ie);
    }

    /**
     * Realiza o cálculo dos dígitos verificadores para a IE do Paraná.
     *
     * @param  string  $ie  IE sanitizada (apenas números)
     * @return bool Retorna true se os dígitos verificadores estiverem corretos.
     */
    private function calculate(string $ie): bool
    {
        $length = strlen($ie);
        $body = substr($ie, 0, $length - 2);

        // Calculando o primeiro dígito
        $firstDigit = self::calculateDigit($body);

        // adicionando o primeiro dígito no corpo para calcular o segundo dígito
        $twoDigit = self::calculateDigit($body.$firstDigit);

        $posTwoDigit = strlen($ie) - 1;

        $posFirstDigit = strlen($ie) - 2;

        return $ie[$posFirstDigit] == $firstDigit && $ie[$posTwoDigit] == $twoDigit;
    }

    /**
     * Informa o digito para o corpo passado
     *
     * @return int dígito
     */
    private static function calculateDigit($body)
    {
        $wight = strlen($body) - 5;

        $sum = 0;
        foreach (str_split($body) as $digit) {
            $sum += $digit * $wight;
            $wight--;
            if ($wight == 1) {
                $wight = 7;
            }
        }

        $module = 11;

        $resto = $sum % $module;

        $dig = $module - $resto;
        if ($dig >= 10) {
            $dig = 0;
        }

        return $dig;
    }
}
