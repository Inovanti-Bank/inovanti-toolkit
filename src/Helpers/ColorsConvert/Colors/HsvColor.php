<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Colors;

use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColor;

class HsvColor extends AbstractColor
{
    private float $hue;

    private float $saturation;

    private float $value;

    public function __construct(float $hue, float $saturation, float $value)
    {
        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->value = $value;
    }

    public function validate(): bool
    {
        return $this->validateRange($this->hue, 0, 360) &&
               $this->validateRange($this->saturation, 0, 100) &&
               $this->validateRange($this->value, 0, 100);
    }

    public function getValues(): array
    {
        return [
            'hue' => $this->hue,
            'saturation' => $this->saturation,
            'value' => $this->value,
        ];
    }

    public function getNormalizedValues(): array
    {
        return [
            'hue' => $this->hue / 360,
            'saturation' => $this->saturation / 100,
            'value' => $this->value / 100,
        ];
    }
}
