<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Colors;

use InovantiBank\Toolkit\Exceptions\GenericException;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColor;

class RgbColor extends AbstractColor
{
    private int $red;

    private int $green;

    private int $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;

        if (! $this->validate()) {
            throw new GenericException('Valores RGB inválidos');
        }
    }

    public function validate(): bool
    {
        return $this->validateRange($this->red, 0, 255) &&
               $this->validateRange($this->green, 0, 255) &&
               $this->validateRange($this->blue, 0, 255);
    }

    public function getValues(): array
    {
        return [
            'red' => $this->red,
            'green' => $this->green,
            'blue' => $this->blue,
        ];
    }

    public function getNormalizedValues(): array
    {
        return [
            'red' => $this->red / 255,
            'green' => $this->green / 255,
            'blue' => $this->blue / 255,
        ];
    }
}
