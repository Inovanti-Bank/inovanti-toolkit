<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Interfaces;

interface ColorConverterInterface
{
    public function toRgb(): string;

    public function toHex(): string;

    public function toCmyk(): string;

    public function toHsv(): string;

    public function toHsl(): string;
}
