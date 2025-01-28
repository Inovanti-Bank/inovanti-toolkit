<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Converters;

use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColorConverter;

class HslConverter extends AbstractColorConverter
{
    public function toRgb(): string
    {
        $values = $this->color->getNormalizedValues();
        $h = $values['hue'] * 360;
        $s = $values['saturation'];
        $l = $values['lightness'];

        // Se não há saturação, é um tom de cinza
        if ($s == 0) {
            $rgb = $this->denormalizeRgb($l);

            return $this->formatRgb($rgb, $rgb, $rgb);
        }

        $q = $l < 0.5 ?
            $l * (1 + $s) :
            $l + $s - $l * $s;
        $p = 2 * $l - $q;

        // Calcula cada componente RGB
        $r = $this->hueToRgb($p, $q, $h + 120);
        $g = $this->hueToRgb($p, $q, $h);
        $b = $this->hueToRgb($p, $q, $h - 120);

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

        // Normaliza RGB para 0-1
        $r = $r / 255;
        $g = $g / 255;
        $b = $b / 255;

        // Calcula K (black)
        $k = 1 - max($r, $g, $b);

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
        $values = $this->color->getNormalizedValues();
        $h = $values['hue'] * 360;
        $s = $values['saturation'];
        $l = $values['lightness'];

        // Converte HSL para HSV
        $v = $l + $s * min($l, 1 - $l);
        $s = $v == 0 ? 0 : 2 * (1 - $l / $v);

        // Converte para porcentagens
        $s *= 100;
        $v *= 100;

        return $this->formatHsvOrHsl($h, $s, $v);
    }

    public function toHsl(): string
    {
        $values = $this->color->getValues();

        return $this->formatHsvOrHsl(
            $values['hue'],
            $values['saturation'],
            $values['lightness']
        );
    }

    protected function normalizeRgbComponent(float $value): int
    {
        return (int) round($this->clamp($value, 0, 1) * 255);
    }
}
