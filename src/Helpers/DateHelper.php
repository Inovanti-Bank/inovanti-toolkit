<?php

namespace InovantiBank\Toolkit\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public function formatDate(string $date, string $formatFrom = 'Y-m-d', string $formatTo = 'd/m/Y'): string
    {
        return Carbon::createFromFormat($formatFrom, $date)->format($formatTo);
    }

    public function addBusinessDays(string $date, int $days): string
    {
        $carbonDate = Carbon::parse($date);
        while ($days > 0) {
            $carbonDate->addDay();
            if (! $carbonDate->isWeekend()) {
                $days--;
            }
        }

        return $carbonDate->format('Y-m-d');
    }
}
