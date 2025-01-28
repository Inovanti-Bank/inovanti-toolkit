<?php

namespace InovantiBank\Toolkit\Helpers;

class BooleanHelper
{
    public function toText(bool $value, string $trueText = 'Sim', string $falseText = 'Não'): string
    {
        return $value ? $trueText : $falseText;
    }

    public function toInteger(bool $value): int
    {
        return $value ? 1 : 0;
    }
}
