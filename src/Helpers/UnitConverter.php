<?php

namespace InovantiBank\Toolkit\Helpers;

class UnitConverter
{
    public function bytesToHumanReadable(int $bytes, int $precision = 2): string
    {
        if ($bytes < 1024) {
            return "$bytes B";
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = floor(log($bytes, 1024));
        $value = $bytes / pow(1024, $pow);

        $formattedValue = number_format($value, $precision, '.', '');

        return "$formattedValue {$units[$pow]}";
    }
}
