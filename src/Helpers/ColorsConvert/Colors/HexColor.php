<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Colors;

use InovantiBank\Toolkit\Exceptions\GenericException;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColor;

class HexColor extends AbstractColor
{
    private string $hex;

    private array $rgbValues;

    public function __construct(string $hex)
    {
        $this->hex = str_replace('#', '', $hex);

        if (! $this->validate()) {
            throw new GenericException('Valor HEX inválido');
        }

        if (strlen($this->hex) === 3) {
            $this->hex = $this->hex[0].$this->hex[0].
                        $this->hex[1].$this->hex[1].
                        $this->hex[2].$this->hex[2];
        }

        $this->rgbValues = $this->parseHexToRgb();
    }

    public function validate(): bool
    {
        return preg_match('/^[A-Fa-f0-9]{3}(?:[A-Fa-f0-9]{3})?$/', $this->hex) === 1;
    }

    public function getValues(): array
    {
        return [
            'hex' => $this->hex,
            'red' => $this->rgbValues['red'],
            'green' => $this->rgbValues['green'],
            'blue' => $this->rgbValues['blue'],
        ];
    }

    private function parseHexToRgb(): array
    {
        return [
            'red' => hexdec(substr($this->hex, 0, 2)),
            'green' => hexdec(substr($this->hex, 2, 2)),
            'blue' => hexdec(substr($this->hex, 4, 2)),
        ];
    }
}
