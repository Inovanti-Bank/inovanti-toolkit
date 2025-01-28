<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Interfaces;

interface ColorInterface
{
    public function validate(): bool;

    public function getValues(): array;
}
