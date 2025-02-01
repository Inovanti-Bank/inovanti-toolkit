<?php

namespace InovantiBank\Toolkit\Interfaces;

interface ValidadorIEInterface
{
    /**
     * Verifica se a Inscrição Estadual informada é válida.
     *
     * @param  string  $ie  Inscrição Estadual (apenas números)
     * @return bool Retorna true se válida, false caso contrário.
     */
    public function isValid(string $ie): bool;
}
