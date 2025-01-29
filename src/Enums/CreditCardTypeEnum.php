<?php

namespace InovantiBank\Toolkit\Enums;

enum CreditCardTypeEnum: string
{
    case VISA = 'Visa';
    case MASTERCARD = 'Mastercard';
    case AMERICAN_EXPRESS = 'American Express';
    case DINERS_CLUB = 'Diners Club';
    case DISCOVER = 'Discover';
    case ENROUTE = 'EnRoute';
    case JCB = 'JCB';
    case VOYAGER = 'Voyager';
    case HIPERCARD = 'Hipercard';
    case AURA = 'Aura';

    /**
     * Retorna a máscara padrão para cada tipo de cartão.
     */
    public function getMask(): string
    {
        return match ($this) {
            self::VISA, self::MASTERCARD, self::DISCOVER, self::HIPERCARD, self::AURA, self::ENROUTE, self::JCB => '#### #### #### ####',

            self::AMERICAN_EXPRESS => '#### ###### #####',

            self::DINERS_CLUB => '#### ###### ####',

            self::VOYAGER => '##### ###### #####',
        };
    }
}
