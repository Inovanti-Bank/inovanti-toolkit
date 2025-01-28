<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Converters;

use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColorConverter;

class HsvConverter extends AbstractColorConverter
{
    public function toRgb(): string
    {
        $values = $this->color->getNormalizedValues();
        $h = $values['hue'] * 360;
        $s = $values['saturation'];
        $v = $values['value'];

        if ($s == 0) {
            $rgb = $v * 255;

            return $this->formatRgb($rgb, $rgb, $rgb);
        }

        $h = $h / 60;
        $i = floor($h);
        $f = $h - $i;

        $p = $v * (1 - $s);
        $q = $v * (1 - $s * $f);
        $t = $v * (1 - $s * (1 - $f));

        switch ($i) {
            case 0:
                $r = $v;
                $g = $t;
                $b = $p;
                break;
            case 1:
                $r = $q;
                $g = $v;
                $b = $p;
                break;
            case 2:
                $r = $p;
                $g = $v;
                $b = $t;
                break;
            case 3:
                $r = $p;
                $g = $q;
                $b = $v;
                break;
            case 4:
                $r = $t;
                $g = $p;
                $b = $v;
                break;
            default:
                $r = $v;
                $g = $p;
                $b = $q;
                break;
        }

        return $this->formatRgb(
            $this->denormalizeRgb($r),
            $this->denormalizeRgb($g),
            $this->denormalizeRgb($b)
        );
    }

    public function toHex(): string
    {
        [$r, $g, $b] = explode(', ', $this->toRgb());

        return $this->formatHex($r, $g, $b);
    }

    public function toCmyk(): string
    {
        [$r, $g, $b] = explode(', ', $this->toRgb());

        $r = $r / 255;
        $g = $g / 255;
        $b = $b / 255;

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

        return $this->formatHsvOrHsl(
            $values['hue'],
            $values['saturation'],
            $values['value']
        );
    }

    public function toHsl(): string
    {
        $values = $this->color->getNormalizedValues();
        $s = $values['saturation'];
        $v = $values['value'];

        $l = $v * (1 - $s / 2);

        $s_hsl = 0;
        if ($l > 0 && $l < 1) {
            $s_hsl = ($v - $l) / min($l, 1 - $l);
        }

        return $this->formatHsvOrHsl(
            $values['hue'] * 360,
            $s_hsl * 100,
            $l * 100
        );
    }
}
