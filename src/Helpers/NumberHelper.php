<?php

namespace InovantiBank\Toolkit\Helpers;

class NumberHelper
{
    public function formatCurrency(float $amount, string $prefix = 'R$'): string
    {
        return $prefix.' '.number_format($amount, 2, ',', '.');
    }

    public function padZero(int $number, int $length): string
    {
        return str_pad($number, $length, '0', STR_PAD_LEFT);
    }

    public function numberToWords(float $value, bool $isCurrency = true): string
    {
        $singular = ['centavo', 'real', 'mil', 'milhão', 'bilhão', 'trilhão', 'quatrilhão'];
        $plural = ['centavos', 'reais', 'mil', 'milhões', 'bilhões', 'trilhões', 'quatrilhões'];

        $c = ['', 'cento', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos', 'seiscentos', 'setecentos', 'oitocentos', 'novecentos'];
        $d = ['', 'dez', 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa'];
        $d10 = ['dez', 'onze', 'doze', 'treze', 'quatorze', 'quinze', 'dezesseis', 'dezessete', 'dezoito', 'dezenove'];
        $u = ['', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove'];

        // Formatar corretamente a parte inteira e decimal
        $value = number_format($value, 2, '.', '');
        [$intPart, $decPart] = explode('.', $value);
        $intPart = (int) $intPart;
        $decPart = (int) $decPart;

        // Gerar texto para a parte inteira
        $intText = $this->convertNumberToWords($intPart, $c, $d, $d10, $u, $singular, $plural);
        $intUnit = ($intPart == 1) ? $singular[1] : $plural[1]; // "real" ou "reais"

        // Gerar texto para a parte decimal (centavos ou números)
        $decText = '';
        if ($decPart > 0) {
            $decText = $this->convertNumberToWords($decPart, $c, $d, $d10, $u, $singular, $plural);
            $decUnit = ($decPart == 1) ? $singular[0] : $plural[0]; // "centavo" ou "centavos"
        }

        // Construção final da string
        if ($isCurrency) {
            if ($intPart == 0) {
                return $decText ? "$decText $decUnit" : 'zero reais';
            }
            if ($decPart > 0) {
                return trim("$intText $intUnit e $decText $decUnit");
            }

            return trim("$intText $intUnit");
        }

        if ($decPart > 0) {
            return trim("$intText e $decText");
        }

        return trim($intText);
    }

    private function convertNumberToWords(int $number, array $c, array $d, array $d10, array $u, array $singular, array $plural): string
    {
        if ($number == 0) {
            return 'zero';
        }

        $text = '';
        $units = ['', 'mil', 'milhão', 'bilhão', 'trilhão', 'quatrilhão'];
        $unitIndex = 0;

        while ($number > 0) {
            $segment = $number % 1000;
            $number = (int) ($number / 1000);

            if ($segment > 0) {
                $segmentText = $this->convertThreeDigitNumberToWords($segment, $c, $d, $d10, $u);

                if ($unitIndex > 0) {
                    $unitText = ($segment == 1) ? $singular[$unitIndex + 1] : $plural[$unitIndex + 1];

                    if ($segmentText === 'um' && $unitIndex === 1) {
                        $segmentText = 'mil';
                    } else {
                        $segmentText .= " $unitText";
                    }
                }

                $text = $segmentText.($text ? ' '.($unitIndex > 0 ? 'e ' : '').$text : '');
            }

            $unitIndex++;
        }

        return trim($text);
    }

    private function convertThreeDigitNumberToWords(int $number, array $c, array $d, array $d10, array $u): string
    {
        if ($number == 0) {
            return '';
        }

        $text = '';

        if ($number >= 100) {
            $centena = (int) ($number / 100);
            $number %= 100;
            if ($centena == 1 && $number > 0) {
                $text .= 'cento';
            } else {
                $text .= $c[$centena];
            }
        }

        if ($number >= 10 && $number <= 19) {
            $text .= ($text ? ' e ' : '').$d10[$number - 10];

            return trim($text);
        }

        if ($number >= 20) {
            $dezena = (int) ($number / 10);
            $number %= 10;
            $text .= ($text ? ' e ' : '').$d[$dezena];
        }

        if ($number > 0) {
            $text .= ($text ? ' e ' : '').$u[$number];
        }

        return trim($text);
    }

    public function formatPercentage(float $value, int $decimals = 2): string
    {
        return number_format($value * 100, $decimals, ',', '.').'%';
    }
}
