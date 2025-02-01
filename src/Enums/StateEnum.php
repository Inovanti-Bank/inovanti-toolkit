<?php

namespace InovantiBank\Toolkit\Enums;

enum StateEnum: string
{
    case AC = 'Acre';
    case AL = 'Alagoas';
    case AP = 'Amapá';
    case AM = 'Amazonas';
    case BA = 'Bahia';
    case CE = 'Ceará';
    case DF = 'Distrito Federal';
    case ES = 'Espírito Santo';
    case GO = 'Goiás';
    case MA = 'Maranhão';
    case MT = 'Mato Grosso';
    case MS = 'Mato Grosso do Sul';
    case MG = 'Minas Gerais';
    case PA = 'Pará';
    case PB = 'Paraíba';
    case PR = 'Paraná';
    case PE = 'Pernambuco';
    case PI = 'Piauí';
    case RJ = 'Rio de Janeiro';
    case RN = 'Rio Grande do Norte';
    case RS = 'Rio Grande do Sul';
    case RO = 'Rondônia';
    case RR = 'Roraima';
    case SC = 'Santa Catarina';
    case SP = 'São Paulo';
    case SE = 'Sergipe';
    case TO = 'Tocantins';

    /**
     * Retorna a máscara padrão da Inscrição Estadual para cada estado.
     */
    public function getIEMask(): array
    {
        return match ($this) {
            self::AC => ['##.###.###/###-##'],
            self::AL => ['#########'],
            self::AP => ['#########'],
            self::AM => ['##.###.###-#'],
            self::BA => ['#######-##'],
            self::CE => ['########-#'],
            self::DF => ['###########-##'],
            self::ES => ['########-#'],
            self::GO => ['##.###.###-#'],
            self::MA => ['########-#'],
            self::MT => ['##########-#'],
            self::MS => ['########-#'],
            self::MG => ['###.###.###/####'],
            self::PA => ['##-######-#'],
            self::PB => ['########-#'],
            self::PR => ['#########-##'],
            self::PE => ['#########-##'],
            self::PI => ['#########'],
            self::RJ => ['##.###.##-#'],
            self::RN => ['##.###.###-#'],
            self::RS => ['###/#######'],
            self::RO => ['############-#'],
            self::RR => ['#########'],
            self::SC => ['###.###.###'],
            self::SP => ['###.###.###.###'],
            self::SE => ['#########-#'],
            self::TO => ['########-#', '##########-#'],
        };
    }

    /**
     * Retorna a quantidade de dígitos esperados para a Inscrição Estadual de cada estado.
     */
    public function getIEDigitLength(): array
    {
        return match ($this) {
            self::AC => [13],
            self::AL => [9],
            self::AP => [9],
            self::AM => [9],
            self::BA => [9],
            self::CE => [9],
            self::DF => [13],
            self::ES => [9],
            self::GO => [9],
            self::MA => [9],
            self::MT => [11],
            self::MS => [9],
            self::MG => [13],
            self::PA => [9],
            self::PB => [9],
            self::PR => [10],
            self::PE => [9],
            self::PI => [9],
            self::RJ => [8],
            self::RN => [9],
            self::RS => [10],
            self::RO => [14],
            self::RR => [9],
            self::SC => [9],
            self::SP => [12],
            self::SE => [9],
            self::TO => [9, 11],
        };
    }
}
