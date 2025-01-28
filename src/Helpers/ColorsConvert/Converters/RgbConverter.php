<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Converters;

use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColorConverter;

class RgbConverter extends AbstractColorConverter
{
    public function toRgb(): string
    {
        $values = $this->color->getValues();

        return $this->formatRgb(
            $values['red'],
            $values['green'],
            $values['blue']
        );
    }

    public function toHex(): string
    {
        $values = $this->color->getValues();

        return $this->formatHex(
            $values['red'],
            $values['green'],
            $values['blue']
        );
    }

    public function toCmyk(): string
    {
        $values = $this->color->getValues();

        // Normaliza RGB para 0-1
        $r = $values['red'] / 255;
        $g = $values['green'] / 255;
        $b = $values['blue'] / 255;

        // Calcula K (black)
        $k = 1 - max($r, $g, $b);

        // Se K é 1, significa que a cor é preta
        if ($k == 1) {
            return $this->formatCmyk(0, 0, 0, 100);
        }

        // Calcula C, M, Y
        $c = (1 - $r - $k) / (1 - $k) * 100;
        $m = (1 - $g - $k) / (1 - $k) * 100;
        $y = (1 - $b - $k) / (1 - $k) * 100;
        $k *= 100;

        return $this->formatCmyk($c, $m, $y, $k);
    }

    public function toHsv(): string
    {
        $values = $this->color->getValues();

        // Normaliza RGB para 0-1
        $r = $values['red'] / 255;
        $g = $values['green'] / 255;
        $b = $values['blue'] / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $delta = $max - $min;

        // Calcula V (value)
        $v = $max * 100;

        // Calcula S (saturation)
        $s = $max == 0 ? 0 : ($delta / $max) * 100;

        // Calcula H (hue)
        if ($delta == 0) {
            $h = 0;
        } elseif ($max == $r) {
            $h = 60 * fmod(($g - $b) / $delta, 6);
        } elseif ($max == $g) {
            $h = 60 * (($b - $r) / $delta + 2);
        } else {
            $h = 60 * (($r - $g) / $delta + 4);
        }

        // Ajusta H para ser positivo
        if ($h < 0) {
            $h += 360;
        }

        return $this->formatHsvOrHsl($h, $s, $v);
    }

    public function toHsl(): string
    {
        $values = $this->color->getValues();

        // Normaliza RGB para 0-1
        $r = $values['red'] / 255;
        $g = $values['green'] / 255;
        $b = $values['blue'] / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        // Calcula L (lightness)
        $l = ($max + $min) / 2;

        // Se max e min são iguais, é um tom de cinza
        if ($max == $min) {
            $h = $s = 0;
        } else {
            $delta = $max - $min;

            // Calcula S (saturation)
            $s = $l > 0.5 ?
                $delta / (2 - $max - $min) :
                $delta / ($max + $min);

            // Calcula H (hue)
            if ($max == $r) {
                $h = ($g - $b) / $delta + ($g < $b ? 6 : 0);
            } elseif ($max == $g) {
                $h = ($b - $r) / $delta + 2;
            } else {
                $h = ($r - $g) / $delta + 4;
            }

            $h *= 60;
            $s *= 100;
        }

        $l *= 100;

        return $this->formatHsvOrHsl($h, $s, $l);
    }
}
