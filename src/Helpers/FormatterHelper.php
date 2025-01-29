<?php

namespace InovantiBank\Toolkit\Helpers;

use Carbon\Carbon;
use InovantiBank\Toolkit\Enums\CreditCardTypeEnum;
use InovantiBank\Toolkit\Enums\StateEnum;
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

    /**
     * Formata um número de telefone para o padrão brasileiro.
     *
     * @param  string  $number  Número de telefone sem formatação
     * @param  bool  $withCountryCode  Incluir código do país (+55)
     * @return string Número formatado
     */
    public function formatPhone(string $number, bool $withCountryCode = false): string
    {
        $number = $this->strHelper->onlyNumbers($number);

        if (strlen($number) === 10) {
            $formatted = sprintf(
                '(%s) %s-%s',
                substr($number, 0, 2),
                substr($number, 2, 4),
                substr($number, 6)
            );
        } elseif (strlen($number) === 11) {
            $formatted = sprintf(
                '(%s) %s %s-%s',
                substr($number, 0, 2),
                substr($number, 2, 1),
                substr($number, 3, 4),
                substr($number, 7)
            );
        } else {
            return throw new InvalidFormatException("o número {$number} não é de telefone válido");
        }

        return $withCountryCode ? "+55 $formatted" : $formatted;
    }

    /**
     * Formata um número de cartão de crédito de acordo com a bandeira.
     *
     * @param  string  $number  Número do cartão sem formatação
     * @param  CreditCardTypeEnum|null  $cardType  Tipo do cartão (opcional)
     * @return string Número formatado
     *
     * @throws InvalidFormatException Se o número não corresponder a um cartão válido
     */
    public function formatCreditCard(string $number, ?CreditCardTypeEnum $cardType = null): string
    {
        $number = $this->strHelper->onlyNumbers($number);

        if (strlen($number) < 13 || strlen($number) > 19) {
            throw new InvalidFormatException("O número {$number} não é um cartão de crédito válido.");
        }

        if ($cardType !== null) {
            return $this->applyMask($number, $cardType->getMask());
        }

        return wordwrap($number, 4, '-', true);
    }

    /**
     * Formata a Inscrição Estadual conforme o estado informado.
     *
     * @param  string  $number  Número da IE sem formatação
     * @param  StateEnum  $state  Estado para aplicar a formatação
     * @return string Número formatado
     *
     * @throws InvalidFormatException Se o estado não for válido
     */
    public function formatIE(string $number, StateEnum $state): string
    {
        $number = $this->strHelper->onlyNumbers($number);

        return $this->applyMask($number, $state->getIEMask());
    }

    /**
     * Aplica uma máscara a um número.
     *
     * @param  string  $value  Número a ser formatado
     * @param  string  $mask  Máscara desejada
     * @return string Número formatado
     */
    private function applyMask(string $value, string $mask): string
    {
        $masked = '';
        $index = 0;
        for ($i = 0; $i < strlen($mask); $i++) {
            if ($mask[$i] === '#') {
                $masked .= isset($value[$index]) ? $value[$index++] : '';
            } else {
                $masked .= $mask[$i];
            }
        }

        return $masked;
    }
}
