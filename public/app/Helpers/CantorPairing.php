<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Log;
/**
 * Calculate a unique integer based on two integers (cantor pairing).
 * @see https://en.wikipedia.org/wiki/Pairing_function#Cantor_pairing_function
 * @see https://gist.github.com/hannesl/8031402
 */
class CantorPairing
{
 
    /**
     * Calculate a unique integer based on two integers (cantor pairing).
     * @param int $x The first integer.
     * @param int $y The second integer.
     * @return int The cantor pair integer.
     */
    public static function cantor_pair_calculate(int $x,int $y) : int
    {
        Log::info('[CantorPairing] cantor_pair_calculate(x,y): '.$x.','.$y);
        return (($x + $y) * ($x + $y + 1)) / 2 + $y;
    }

    /**
     * Return the source integers from a cantor pair integer.
     * @param int $z The cantor pair integer.
     * @return array The source integers.
     */
    public static function cantor_pair_reverse(int $z) : array
    {
        $t = floor((-1 + sqrt(1 + 8 * $z)) / 2);
        $x = $t * ($t + 3) / 2 - $z;
        $y = $z - $t * ($t + 1) / 2;
        return array($x, $y);
    }

}