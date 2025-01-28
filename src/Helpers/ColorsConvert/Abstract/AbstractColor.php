<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract;

use InovantiBank\Toolkit\Exceptions\GenericException;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Interfaces\ColorInterface;

abstract class AbstractColor implements ColorInterface
{
    protected function validateRange(float $value, float $min, float $max): bool
    {
        return $value >= $min && $value <= $max;
    }

    public function throwInvalidColorException(): void
    {
        throw new GenericException(
            sprintf('Cor %s inválida', static::class)
        );
    }

    abstract public function validate(): bool;
}
