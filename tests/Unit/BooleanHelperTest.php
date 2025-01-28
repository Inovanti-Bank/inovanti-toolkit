<?php

namespace Tests\Unit;

use InovantiBank\Toolkit\Helpers\BooleanHelper;
use PHPUnit\Framework\TestCase;

class BooleanHelperTest extends TestCase
{
    protected BooleanHelper $booleanHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->booleanHelper = new BooleanHelper;
    }

    public function test_converts_boolean_to_text_with_default_values()
    {
        $this->assertSame('Sim', $this->booleanHelper->toText(true));
        $this->assertSame('Não', $this->booleanHelper->toText(false));
    }

    public function test_converts_boolean_to_text_with_custom_values()
    {
        $this->assertSame('Yes', $this->booleanHelper->toText(true, 'Yes', 'No'));
        $this->assertSame('No', $this->booleanHelper->toText(false, 'Yes', 'No'));
    }

    public function test_converts_boolean_to_integer()
    {
        $this->assertSame(1, $this->booleanHelper->toInteger(true));
        $this->assertSame(0, $this->booleanHelper->toInteger(false));
    }
}
