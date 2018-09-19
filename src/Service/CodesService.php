<?php

namespace App\Service;

use App\Util\CodesInterface;

/**
 * Class CodesService
 * @package App\Service
 */
class CodesService implements CodesInterface
{
    /**
     * List of all possible characters
     */
    protected const CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Safety Buffer ( 0 - 100 )%
     */
    protected const BUFFER = 10;

    /**
     * Generates unique discout codes, if amount requested is to big returns null
     * @param int $numberOfCodes
     * @param int $lengthOfCodes
     * @return array|null
     */
    public function generate(int $numberOfCodes, int $lengthOfCodes): ?array
    {
        if ($this->getMaxResults($lengthOfCodes) < $numberOfCodes) return null;
        $codes = [];
        $i = 1;
        while ($i <= $numberOfCodes) {
            $code = '';
            for ($j = 0; $j < $lengthOfCodes; $j++) {
                $code .= self::CHARS[mt_rand(0, strlen(self::CHARS) - 1)];
            }
            $codes[$code] = $code;
            // remove duplicates if needed
            if ($i == $numberOfCodes) {
                $codes = array_unique($codes);
                $count = count($codes);
                $i -= $numberOfCodes - $count;
            }
            $i++;
        }

        return $codes;
    }

    /**
     * Returns max possible results reduced by safety buffer
     * @param int $lengthOfCodes
     * @return float|int
     */
    protected function getMaxResults(int $lengthOfCodes)
    {
        $maxResults = pow(strlen(self::CHARS), $lengthOfCodes) * (abs(100 - self::BUFFER) / 100);
        return $maxResults;
    }

}