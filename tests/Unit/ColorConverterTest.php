<?php

namespace Tests\Unit;

use InovantiBank\Toolkit\Exceptions\GenericException;
use InovantiBank\Toolkit\Helpers\ColorConverter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ColorConverterTest extends TestCase
{
    protected ColorConverter $converter;

    protected array $colors;

    protected function setUp(): void
    {
        parent::setUp();
        $this->converter = new ColorConverter;

        $this->colors = [
            'hex' => '#f0e400',
            'rgb' => '240, 228, 0',
            'cmyk' => '0%, 5%, 100%, 6%',
            'hsv' => '57°, 100%, 94%',
            'hsl' => '57°, 100%, 47%',
        ];
    }

    #[Test]
    #[DataProvider('colorConversionProvider')]
    public function it_converts_colors_correctly(string $fromFormat, string $toFormat): void
    {
        $result = $this->converter->convert(
            $this->colors[$fromFormat],
            $toFormat,
            $fromFormat
        );

        $this->assertEquals(
            $this->normalizeColorString($this->colors[$toFormat]),
            $this->normalizeColorString($result)
        );
    }

    public static function colorConversionProvider(): array
    {
        $formats = ['hex', 'rgb', 'cmyk', 'hsv', 'hsl'];
        $combinations = [];

        foreach ($formats as $from) {
            foreach ($formats as $to) {
                $combinations["convert_{$from}_to_{$to}"] = [$from, $to];
            }
        }

        return $combinations;
    }

    #[Test]
    public function it_detects_hex_format_automatically(): void
    {
        $result = $this->converter->convert('#f0e400', 'rgb');
        $this->assertEquals(
            $this->normalizeColorString($this->colors['rgb']),
            $this->normalizeColorString($result)
        );
    }

    #[Test]
    public function it_detects_rgb_format_automatically(): void
    {
        $result = $this->converter->convert('240, 228, 0', 'hex');
        $this->assertEquals(
            $this->normalizeColorString($this->colors['hex']),
            $this->normalizeColorString($result)
        );
    }

    #[Test]
    public function it_throws_exception_for_invalid_input_format(): void
    {
        $this->expectException(GenericException::class);
        $this->converter->convert('invalid color', 'rgb');
    }

    #[Test]
    public function it_throws_exception_for_invalid_output_format(): void
    {
        $this->expectException(GenericException::class);
        $this->converter->convert('#f0e400', 'invalid');
    }

    #[Test]
    #[DataProvider('invalidColorValuesProvider')]
    public function it_throws_exception_for_invalid_color_values(string $color, string $format): void
    {
        $this->expectException(GenericException::class);
        $this->converter->convert($color, 'rgb', $format);
    }

    public static function invalidColorValuesProvider(): array
    {
        return [
            'invalid_hex' => ['#GGGGGG', 'hex'],
            'invalid_rgb' => ['256, 300, -1', 'rgb'],
            'invalid_cmyk' => ['150%, 50%, 50%, 50%', 'cmyk'],
            'invalid_hsv' => ['400°, 150%, 50%', 'hsv'],
            'invalid_hsl' => ['360°, 150%, 150%', 'hsl'],
        ];
    }

    #[Test]
    #[DataProvider('edgeCaseColorsProvider')]
    public function it_handles_edge_case_colors_correctly(string $color, string $format, string $expectedRgb): void
    {
        $result = $this->converter->convert($color, 'rgb', $format);
        $this->assertEquals(
            $this->normalizeColorString($expectedRgb),
            $this->normalizeColorString($result)
        );
    }

    public static function edgeCaseColorsProvider(): array
    {
        return [
            'black_hex' => ['#000000', 'hex', '0, 0, 0'],
            'white_hex' => ['#FFFFFF', 'hex', '255, 255, 255'],
            'black_rgb' => ['0, 0, 0', 'rgb', '0, 0, 0'],
            'white_rgb' => ['255, 255, 255', 'rgb', '255, 255, 255'],
            'black_cmyk' => ['0%, 0%, 0%, 100%', 'cmyk', '0, 0, 0'],
            'white_cmyk' => ['0%, 0%, 0%, 0%', 'cmyk', '255, 255, 255'],
            'gray_hsl' => ['0°, 0%, 50%', 'hsl', '128, 128, 128'],
        ];
    }

    #[Test]
    public function it_handles_shorthand_hex_colors(): void
    {
        $result = $this->converter->convert('#FFF', 'rgb', 'hex');
        $this->assertEquals(
            $this->normalizeColorString('255, 255, 255'),
            $this->normalizeColorString($result)
        );
    }

    #[Test]
    public function it_handles_case_insensitive_hex_colors(): void
    {
        $result1 = $this->converter->convert('#f0e400', 'rgb', 'hex');
        $result2 = $this->converter->convert('#F0E400', 'rgb', 'hex');

        $this->assertEquals(
            $this->normalizeColorString($result1),
            $this->normalizeColorString($result2)
        );
    }

    #[Test]
    #[DataProvider('colorWithSpacesProvider')]
    public function it_handles_different_spacing_formats(string $input, string $format, string $expected): void
    {
        $result = $this->converter->convert($input, 'rgb', $format);
        $this->assertEquals(
            $this->normalizeColorString($expected),
            $this->normalizeColorString($result)
        );
    }

    public static function colorWithSpacesProvider(): array
    {
        return [
            'rgb_no_spaces' => ['240,228,0', 'rgb', '240, 228, 0'],
            'rgb_extra_spaces' => ['240,  228,    0', 'rgb', '240, 228, 0'],
            'cmyk_no_spaces' => ['0%,5%,100%,6%', 'cmyk', '240, 228, 0'],
            'cmyk_extra_spaces' => ['0%,  5%,  100%,  6%', 'cmyk', '240, 228, 0'],
        ];
    }

    private function normalizeColorString(string $color): string
    {
        $color = strtolower(trim($color));
        $color = str_replace(['°', '%'], '', $color);

        return preg_replace('/\s*,\s*/', ',', $color);
    }
}
