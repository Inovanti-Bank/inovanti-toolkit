<?php

namespace InovantiBank\Toolkit\Support;

use InovantiBank\Toolkit\Contracts\ToolkitInterface;
use InovantiBank\Toolkit\Helpers\ArrayHelper;
use InovantiBank\Toolkit\Helpers\BooleanHelper;
use InovantiBank\Toolkit\Helpers\ColorConverter;
use InovantiBank\Toolkit\Helpers\DateHelper;
use InovantiBank\Toolkit\Helpers\FormatterHelper;
use InovantiBank\Toolkit\Helpers\NumberHelper;
use InovantiBank\Toolkit\Helpers\StringHelper;
use InovantiBank\Toolkit\Helpers\UnitConverter;
use InovantiBank\Toolkit\Helpers\ValidatorHelper;

class ToolkitManager implements ToolkitInterface
{
    private ArrayHelper $arrayHelper;

    private BooleanHelper $booleanHelper;

    private ColorConverter $colorConverter;

    private DateHelper $dateHelper;

    private FormatterHelper $formatterHelper;

    private NumberHelper $numberHelper;

    private StringHelper $stringHelper;

    private UnitConverter $unitConverter;

    private ValidatorHelper $validatorHelper;

    public function __construct(
        ArrayHelper $arrayHelper,
        BooleanHelper $booleanHelper,
        ColorConverter $colorConverter,
        DateHelper $dateHelper,
        FormatterHelper $formatterHelper,
        NumberHelper $numberHelper,
        StringHelper $stringHelper,
        UnitConverter $unitConverter,
        ValidatorHelper $validatorHelper
    ) {
        $this->arrayHelper = $arrayHelper;
        $this->booleanHelper = $booleanHelper;
        $this->colorConverter = $colorConverter;
        $this->dateHelper = $dateHelper;
        $this->formatterHelper = $formatterHelper;
        $this->numberHelper = $numberHelper;
        $this->stringHelper = $stringHelper;
        $this->unitConverter = $unitConverter;
        $this->validatorHelper = $validatorHelper;
    }

    public function getArrayHelper(): ArrayHelper
    {
        return $this->arrayHelper;
    }

    public function getBooleanHelper(): BooleanHelper
    {
        return $this->booleanHelper;
    }

    public function getColorConverter(): ColorConverter
    {
        return $this->colorConverter;
    }

    public function getDateHelper(): DateHelper
    {
        return $this->dateHelper;
    }

    public function getFormatterHelper(): FormatterHelper
    {
        return $this->formatterHelper;
    }

    public function getNumberHelper(): NumberHelper
    {
        return $this->numberHelper;
    }

    public function getStringHelper(): StringHelper
    {
        return $this->stringHelper;
    }

    public function getUnitConverter(): UnitConverter
    {
        return $this->unitConverter;
    }

    public function getValidatorHelper(): ValidatorHelper
    {
        return $this->validatorHelper;
    }
}
