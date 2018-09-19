<?php

namespace App\Util;

/**
 * Interface CodesInterface
 * @package App\Util
 */
interface CodesInterface
{
    /**
     * Generate Method
     * @param int $numberOfCodes
     * @param int $lengthOfCodes
     * @return array|null
     */
    public function generate(int $numberOfCodes, int $lengthOfCodes): ?array;
}