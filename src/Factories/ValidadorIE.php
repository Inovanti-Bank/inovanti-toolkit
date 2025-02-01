<?php

namespace InovantiBank\Toolkit\Factories;

use InovantiBank\Toolkit\Enums\StateEnum;
use InovantiBank\Toolkit\Interfaces\ValidadorIEInterface;
use InovantiBank\Toolkit\Validators\ValidatorsIE\AcreValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\AlagoasValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\AmapaValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\AmazonasValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\BahiaValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\CearaValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\DistritoFederalValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\EspiritoSantoValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\GoiasValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\MaranhaoValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\MatoGrossoDoSulValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\MatoGrossoValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\MinasGeraisValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\ParaibaValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\ParanaValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\ParaValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\PernambucoValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\PiauiValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\RioDeJaneiroValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\RioGrandeDoNorteValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\RioGrandeDoSulValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\RondoniaValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\RoraimaValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\SantaCatarinaValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\SaoPauloValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\SergipeValidator;
use InovantiBank\Toolkit\Validators\ValidatorsIE\TocantinsValidator;
use InvalidArgumentException;

class ValidadorIE
{
    /**
     * Método principal para verificação da IE.
     *
     * @param  StateEnum  $state  Estado para o qual a IE será validada.
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool True se a IE for válida para o estado, false caso contrário.
     *
     * @throws \InvalidArgumentException Se o validador para o estado não estiver implementado.
     */
    public static function check(StateEnum $state, string $ie): bool
    {
        $validator = self::getValidator($state);

        return $validator->isValid($ie);
    }

    /**
     * Retorna a instância do validador específico para o estado.
     *
     * @param  StateEnum  $state  Estado da IE
     *
     * @throws \InvalidArgumentException Se o estado não for suportado.
     */
    private static function getValidator(StateEnum $state): ValidadorIEInterface
    {
        return match ($state) {
            StateEnum::AC => new AcreValidator,
            StateEnum::AL => new AlagoasValidator,
            StateEnum::AP => new AmapaValidator,
            StateEnum::AM => new AmazonasValidator,
            StateEnum::BA => new BahiaValidator,
            StateEnum::CE => new CearaValidator,
            StateEnum::DF => new DistritoFederalValidator,
            StateEnum::ES => new EspiritoSantoValidator,
            StateEnum::GO => new GoiasValidator,
            StateEnum::MA => new MaranhaoValidator,
            StateEnum::MT => new MatoGrossoValidator,
            StateEnum::MS => new MatoGrossoDoSulValidator,
            StateEnum::MG => new MinasGeraisValidator,
            StateEnum::PA => new ParaValidator,
            StateEnum::PB => new ParaibaValidator,
            StateEnum::PR => new ParanaValidator,
            StateEnum::PE => new PernambucoValidator,
            StateEnum::PI => new PiauiValidator,
            StateEnum::RJ => new RioDeJaneiroValidator,
            StateEnum::RN => new RioGrandeDoNorteValidator,
            StateEnum::RS => new RioGrandeDoSulValidator,
            StateEnum::RO => new RondoniaValidator,
            StateEnum::RR => new RoraimaValidator,
            StateEnum::SC => new SantaCatarinaValidator,
            StateEnum::SP => new SaoPauloValidator,
            StateEnum::SE => new SergipeValidator,
            StateEnum::TO => new TocantinsValidator,
            default => throw new InvalidArgumentException("Validador para o estado {$state->name} não implementado."),
        };
    }
}
