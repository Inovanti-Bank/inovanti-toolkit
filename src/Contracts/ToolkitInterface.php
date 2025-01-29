<?php

namespace InovantiBank\Toolkit\Contracts;

use InovantiBank\Toolkit\Helpers\ArrayHelper;
use InovantiBank\Toolkit\Helpers\BooleanHelper;
use InovantiBank\Toolkit\Helpers\ColorConverter;
use InovantiBank\Toolkit\Helpers\DateHelper;
use InovantiBank\Toolkit\Helpers\FormatterHelper;
use InovantiBank\Toolkit\Helpers\NumberHelper;
use InovantiBank\Toolkit\Helpers\StringHelper;
use InovantiBank\Toolkit\Helpers\UnitConverter;
use InovantiBank\Toolkit\Helpers\ValidatorHelper;

interface ToolkitInterface
{
    public function getArrayHelper(): ArrayHelper;

    public function getBooleanHelper(): BooleanHelper;

    public function getColorConverter(): ColorConverter;

    public function getDateHelper(): DateHelper;

    public function getFormatterHelper(): FormatterHelper;

    public function getNumberHelper(): NumberHelper;

    public function getStringHelper(): StringHelper;

    public function getUnitConverter(): UnitConverter;

    public function getValidatorHelper(): ValidatorHelper;
}
