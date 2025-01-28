<?php

namespace InovantiBank\Toolkit\Helpers;

use InovantiBank\Toolkit\Exceptions\GenericException;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColor;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Abstract\AbstractColorConverter;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Colors\CmykColor;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Colors\HexColor;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Colors\HslColor;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Colors\HsvColor;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Colors\RgbColor;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Converters\CmykConverter;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Converters\HexConverter;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Converters\HslConverter;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Converters\HsvConverter;
use InovantiBank\Toolkit\Helpers\ColorsConvert\Converters\RgbConverter;

class ColorConverter
{
    private const FORMATS = ['hex', 'rgb', 'cmyk', 'hsv', 'hsl'];

    public function convert(string $color, string $toFormat, ?string $fromFormat = null): string
    {
        $toFormat = strtolower($toFormat);

        if (! in_array($toFormat, self::FORMATS)) {
            throw new GenericException("Formato de conversão '$toFormat' inválido");
        }

        try {
            $colorObject = $fromFormat ?
                $this->createColorFromFormat($color, $fromFormat) :
                $this->detectColorFormat($color);

            $converter = $this->createConverter($colorObject);

            return match ($toFormat) {
                'hex' => $converter->toHex(),
                'rgb' => $converter->toRgb(),
                'cmyk' => $converter->toCmyk(),
                'hsv' => $converter->toHsv(),
                'hsl' => $converter->toHsl(),
            };
        } catch (GenericException $e) {
            throw new GenericException('Cor inválida: '.$e->getMessage());
        }
    }

    private function createConverter(AbstractColor $color): AbstractColorConverter
    {
        return match (get_class($color)) {
            RgbColor::class => new RgbConverter($color),
            HexColor::class => new HexConverter($color),
            CmykColor::class => new CmykConverter($color),
            HsvColor::class => new HsvConverter($color),
            HslColor::class => new HslConverter($color),
            default => throw new GenericException('Formato de cor não suportado'),
        };
    }

    private function detectColorFormat(string $color): AbstractColor
    {
        $color = trim($color);

        $cleanColor = preg_replace('/[^0-9\s,\.#%°]/', '', $color);

        if (preg_match('/^#?([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
            return new HexColor($color);
        }

        $values = $this->extractValues($cleanColor);
        $valueCount = count($values);

        if ($valueCount === 3) {
            if (strpos($color, '%') !== false) {
                if ($this->isLikelyHsl($values)) {
                    return new HslColor(...array_values($values));
                }

                return new HsvColor(...array_values($values));
            }

            if ($this->isRgbRange($values)) {
                return new RgbColor(...array_values($values));
            }
        }

        if ($valueCount === 4 && strpos($color, '%') !== false) {
            return new CmykColor(...array_values($values));
        }

        throw new GenericException('Formato de cor não reconhecido');
    }

    private function createColorFromFormat(string $color, string $format): AbstractColor
    {
        $values = $this->extractValues($color);

        return match (strtolower($format)) {
            'hex' => new HexColor($color),
            'rgb' => $this->createRgbColor($values),
            'cmyk' => $this->createCmykColor($values),
            'hsv' => $this->createHsvColor($values),
            'hsl' => $this->createHslColor($values),
            default => throw new GenericException("Formato '$format' não suportado"),
        };
    }

    private function extractValues(string $color): array
    {
        $color = str_replace(['°', '%'], '', $color);

        if (strpos($color, ',') !== false) {
            $values = array_map('trim', explode(',', $color));
        } else {
            $values = array_values(array_filter(explode(' ', $color), 'strlen'));
        }

        return array_map('floatval', $values);
    }

    private function isRgbRange(array $values): bool
    {
        foreach ($values as $value) {
            if ($value < 0 || $value > 255) {
                return false;
            }
        }

        return true;
    }

    private function isLikelyHsl(array $values): bool
    {
        // HSL tem características específicas:
        // - Luminosidade raramente > 90%
        // - Saturação tem relação com luminosidade
        $h = $values[0];
        $s = $values[1];
        $l = $values[2];

        // Verifica se está dentro dos ranges típicos de HSL
        if ($l > 90) {
            return false;
        }
        if ($l <= 50 && $s > $l * 2) {
            return false;
        }
        if ($l > 50 && $s > (100 - $l) * 2) {
            return false;
        }

        return true;
    }

    private function createRgbColor(array $values): RgbColor
    {
        $this->validateValueCount($values, 3);

        return new RgbColor(
            (int) $values[0],
            (int) $values[1],
            (int) $values[2]
        );
    }

    private function createCmykColor(array $values): CmykColor
    {
        $this->validateValueCount($values, 4);

        return new CmykColor(
            (float) $values[0],
            (float) $values[1],
            (float) $values[2],
            (float) $values[3]
        );
    }

    private function createHsvColor(array $values): HsvColor
    {
        $this->validateValueCount($values, 3);

        return new HsvColor(
            (float) $values[0],
            (float) $values[1],
            (float) $values[2]
        );
    }

    private function createHslColor(array $values): HslColor
    {
        $this->validateValueCount($values, 3);

        return new HslColor(
            (float) $values[0],
            (float) $values[1],
            (float) $values[2]
        );
    }

    private function validateValueCount(array $values, int $expected): void
    {
        if (count($values) !== $expected) {
            throw new GenericException(
                "Número incorreto de valores. Esperado: $expected, Recebido: ".count($values)
            );
        }
    }
}
