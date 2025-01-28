<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Converters;

use App\Services\Colors\HexColor;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColorConverter;

class HexConverter extends AbstractColorConverter
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

        return '#'.$values['hex'];
    }

    public function toCmyk(): string
    {
        // Usa os valores RGB já convertidos do HexColor
        $values = $this->color->getValues();
        $r = $values['red'] / 255;
        $g = $values['green'] / 255;
        $b = $values['blue'] / 255;

        $k = 1 - max($r, $g, $b);

        if ($k == 1) {
            return $this->formatCmyk(0, 0, 0, 100);
        }

        $c = (1 - $r - $k) / (1 - $k) * 100;
        $m = (1 - $g - $k) / (1 - $k) * 100;
        $y = (1 - $b - $k) / (1 - $k) * 100;
        $k *= 100;

        return $this->formatCmyk($c, $m, $y, $k);
    }

    public function toHsv(): string
    {
        $values = $this->color->getValues();
        $r = $values['red'] / 255;
        $g = $values['green'] / 255;
        $b = $values['blue'] / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $delta = $max - $min;

        // Calcula H
        if ($delta == 0) {
            $h = 0;
        } elseif ($max == $r) {
            $h = 60 * fmod(($g - $b) / $delta, 6);
        } elseif ($max == $g) {
            $h = 60 * (($b - $r) / $delta + 2);
        } else {
            $h = 60 * (($r - $g) / $delta + 4);
        }

        if ($h < 0) {
            $h += 360;
        }

        // Calcula S
        $s = $max == 0 ? 0 : ($delta / $max) * 100;

        // Calcula V
        $v = $max * 100;

        return $this->formatHsvOrHsl($h, $s, $v);
    }

    public function toHsl(): string
    {
        $values = $this->color->getValues();
        $r = $values['red'] / 255;
        $g = $values['green'] / 255;
        $b = $values['blue'] / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        $l = ($max + $min) / 2;

        if ($max == $min) {
            $h = $s = 0;
        } else {
            $delta = $max - $min;

            $s = $l > 0.5 ?
                $delta / (2 - $max - $min) :
                $delta / ($max + $min);

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
