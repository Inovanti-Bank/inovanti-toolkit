<?php

namespace InovantiBank\Toolkit\Traits\ColorsConvert;

trait ColorConversionTrait
{
    protected function normalizeRgb(int $value): float
    {
        return $value / 255;
    }

    protected function denormalizeRgb(float $value): int
    {
        return round($value * 255);
    }

    protected function clamp(float $value, float $min, float $max): float
    {
        return max($min, min($max, $value));
    }

    protected function normalizeHue(float $hue): float
    {
        $hue = fmod($hue, 360);

        return $hue < 0 ? $hue + 360 : $hue;
    }

    protected function hueToRgb(float $p, float $q, float $h): float
    {
        $h = $this->normalizeHue($h);

        if ($h < 60) {
            return $p + ($q - $p) * $h / 60;
        }
        if ($h < 180) {
            return $q;
        }
        if ($h < 240) {
            return $p + ($q - $p) * (240 - $h) / 60;
        }

        return $p;
    }
}
