<?php

namespace App\Service;

interface ITranslator
{
    public function translate(string $string, string $from, string $to): string;
}
