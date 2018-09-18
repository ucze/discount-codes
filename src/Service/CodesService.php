<?php

namespace App\Service;

use App\Util\CodesInterface;

class CodesService implements CodesInterface
{
    protected const CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    protected const BUFFER = 10;

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

    protected function getMaxResults(int $lengthOfCodes)
    {
        $maxResults = pow(strlen(self::CHARS), $lengthOfCodes) * (abs(100 - self::BUFFER) / 100);
        return $maxResults;
    }

}