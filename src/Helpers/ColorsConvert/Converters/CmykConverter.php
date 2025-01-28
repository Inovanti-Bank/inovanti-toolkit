<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Converters;

use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColorConverter;

class CmykConverter extends AbstractColorConverter
{
    public function toRgb(): string
    {
        $values = $this->color->getNormalizedValues();
        $c = $values['cyan'];
        $m = $values['magenta'];
        $y = $values['yellow'];
        $k = $values['key'];

        $r = round(255 * (1 - $c) * (1 - $k));
        $g = round(255 * (1 - $m) * (1 - $k));
        $b = round(255 * (1 - $y) * (1 - $k));

        return $this->formatRgb($r, $g, $b);
    }

    public function toHex(): string
    {
        [$r, $g, $b] = explode(', ', $this->toRgb());

        return $this->formatHex($r, $g, $b);
    }

    public function toCmyk(): string
    {
        $values = $this->color->getValues();

        return $this->formatCmyk(
            $values['cyan'],
            $values['magenta'],
            $values['yellow'],
            $values['key']
        );
    }

    public function toHsv(): string
    {
        [$r, $g, $b] = explode(', ', $this->toRgb());

        $r = $r / 255;
        $g = $g / 255;
        $b = $b / 255;

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

        // Calcula S e V
        $s = $max == 0 ? 0 : ($delta / $max) * 100;
        $v = $max * 100;

        return $this->formatHsvOrHsl($h, $s, $v);
    }

    public function toHsl(): string
    {
        [$r, $g, $b] = explode(', ', $this->toRgb());

        $r = $r / 255;
        $g = $g / 255;
        $b = $b / 255;

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
