<?php

namespace App\Util;

interface CodesInterface
{
    public function generate(int $numberOfCodes, int $lengthOfCodes): ?array;
}