<?php

namespace InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract;

use InovantiBank\Toolkit\Exceptions\GenericException;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Interfaces\ColorConverterInterface;
use InovantiBank\Toolkit\Traits\ColorsConvert\ColorConversionTrait;
use InovantiBank\Toolkit\Traits\ColorsConvert\ColorFormattingTrait;

abstract class AbstractColorConverter implements ColorConverterInterface
{
    use ColorConversionTrait;
    use ColorFormattingTrait;

    protected AbstractColor $color;

    public function __construct(AbstractColor $color)
    {
        if (! $color->validate()) {
            throw new GenericException(
                sprintf('Valores inválidos para cor %s', get_class($color))
            );
        }
        $this->color = $color;
    }
}
