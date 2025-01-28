<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Colors;

use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColor;

class CmykColor extends AbstractColor
{
    private float $cyan;

    private float $magenta;

    private float $yellow;

    private float $key;

    public function __construct(float $cyan, float $magenta, float $yellow, float $key)
    {
        $this->cyan = $cyan;
        $this->magenta = $magenta;
        $this->yellow = $yellow;
        $this->key = $key;
    }

    public function validate(): bool
    {
        return $this->validateRange($this->cyan, 0, 100) &&
               $this->validateRange($this->magenta, 0, 100) &&
               $this->validateRange($this->yellow, 0, 100) &&
               $this->validateRange($this->key, 0, 100);
    }

    public function getValues(): array
    {
        return [
            'cyan' => $this->cyan,
            'magenta' => $this->magenta,
            'yellow' => $this->yellow,
            'key' => $this->key,
        ];
    }

    public function getNormalizedValues(): array
    {
        return [
            'cyan' => $this->cyan / 100,
            'magenta' => $this->magenta / 100,
            'yellow' => $this->yellow / 100,
            'key' => $this->key / 100,
        ];
    }
}
