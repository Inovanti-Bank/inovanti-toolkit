<?php

namespace InovantiBank\Toolkit\Support;

use InovantiBank\Toolkit\Helpers\ArrayHelper;
use InovantiBank\Toolkit\Helpers\BooleanHelper;
use InovantiBank\Toolkit\Helpers\ColorConverter;
use InovantiBank\Toolkit\Helpers\DateHelper;
use InovantiBank\Toolkit\Helpers\FormatterHelper;
use InovantiBank\Toolkit\Helpers\NumberHelper;
use InovantiBank\Toolkit\Helpers\StringHelper;
use InovantiBank\Toolkit\Helpers\UnitConverter;
use InovantiBank\Toolkit\Helpers\ValidatorHelper;

class ToolkitManager
{
    public function arrayConverter(): ArrayHelper
    {
        return new ArrayHelper;
    }

    public function booleanConverter(): BooleanHelper
    {
        return new BooleanHelper;
    }

    public function colorConverter(): ColorConverter
    {
        return new ColorConverter;
    }

    public function dateConverter(): DateHelper
    {
        return new DateHelper;
    }

    public function formatter(): FormatterHelper
    {
        return new FormatterHelper;
    }

    public function numberConverter(): NumberHelper
    {
        return new NumberHelper;
    }

    public function stringConverter(): StringHelper
    {
        return new StringHelper;
    }

    public function unitConverter(): UnitConverter
    {
        return new UnitConverter;
    }

    public function validator(): ValidatorHelper
    {
        return new ValidatorHelper(new StringHelper);
    }
}
