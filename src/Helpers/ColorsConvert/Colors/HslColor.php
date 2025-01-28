<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Colors;

use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColor;

class HslColor extends AbstractColor
{
    private float $hue;

    private float $saturation;

    private float $lightness;

    public function __construct(float $hue, float $saturation, float $lightness)
    {
        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->lightness = $lightness;
    }

    public function validate(): bool
    {
        return $this->validateRange($this->hue, 0, 360) &&
               $this->validateRange($this->saturation, 0, 100) &&
               $this->validateRange($this->lightness, 0, 100);
    }

    public function getValues(): array
    {
        return [
            'hue' => $this->hue,
            'saturation' => $this->saturation,
            'lightness' => $this->lightness,
        ];
    }

    public function getNormalizedValues(): array
    {
        return [
            'hue' => $this->hue / 360,
            'saturation' => $this->saturation / 100,
            'lightness' => $this->lightness / 100,
        ];
    }
}
