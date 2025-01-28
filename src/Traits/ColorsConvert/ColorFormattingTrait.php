<?php

namespace InovantiBank\Toolkit\Traits\ColorsConvert;

trait ColorFormattingTrait
{
    protected function formatPercentage(float $value): string
    {
        return round($value).'%';
    }

    protected function formatDegree(float $value): string
    {
        return round($value).'°';
    }

    protected function formatRgb(int $r, int $g, int $b): string
    {
        return "$r, $g, $b";
    }

    protected function formatHex(int $r, int $g, int $b): string
    {
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }

    protected function formatCmyk(float $c, float $m, float $y, float $k): string
    {
        return sprintf(
            '%s, %s, %s, %s',
            $this->formatPercentage($c),
            $this->formatPercentage($m),
            $this->formatPercentage($y),
            $this->formatPercentage($k)
        );
    }

    protected function formatHsvOrHsl(float $h, float $s, float $v): string
    {
        return sprintf(
            '%s, %s, %s',
            $this->formatDegree($h),
            $this->formatPercentage($s),
            $this->formatPercentage($v)
        );
    }
}
