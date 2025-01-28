<?php

namespace InovantiBank\Toolkit\Helpers;

use Carbon\Carbon;
use InovantiBank\Toolkit\Exceptions\InvalidFormatException;

class FormatterHelper
{
    public function __construct(protected StringHelper $strHelper) {}

    /**
     * Formata CPF ou CNPJ para o padrão brasileiro"
     */
    public function formatCpfCnpj(string $number): string
    {
        $number = $this->strHelper->onlyNumbers($number);

        return match (strlen($number)) {
            11 => preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $number),
            14 => preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $number),
            default => throw new InvalidFormatException('Invalid CPF/CNPJ format')
        };
    }

    /**
     * Formata a data no formato longo: "28 de janeiro de 2025"
     */
    public function formatDateHuman(string $date): string
    {
        return Carbon::parse($date)->translatedFormat('j \d\e F \d\e Y');
    }

    /**
     * Formata a data no formato curto: "28 de jan. de 2025"
     */
    public function formatDateShortHuman(string $date): string
    {
        return Carbon::parse($date)->translatedFormat('j \d\e M \d\e Y');
    }

    /**
     * Formata a data e a hora: "ter., 28 de jan. de 2025, 14:01"
     */
    public function formatDateTimeHuman(string $date): string
    {
        return Carbon::parse($date)->translatedFormat('D, j \d\e M \d\e Y, H:i');
    }

    /**
     * Formata como data relativa: "há 2 dias" ou "daqui a 3 horas"
     */
    public function formatDateRelative(string $date): string
    {
        return Carbon::parse($date)->diffForHumans();
    }

    /**
     * Retorna o dia da semana e a data completa: "terça-feira, 28 de janeiro de 2025"
     */
    public function formatDateWeekday(string $date): string
    {
        return Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e Y');
    }

    /**
     * Retorna um formato personalizado baseado em um padrão do usuário
     */
    public function formatDateCustom(string $date, string $format): string
    {
        return Carbon::parse($date)->translatedFormat($format);
    }
}
