<?php

namespace Zaxxo\LaravelBruteforce;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Represent a bruteforce attempt.
 *
 * @package Zaxxo\LaravelBruteforce
 * @internal
 */
class BruteforceAttempt extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Return the lifetime of an attempt.
     *
     * @return Carbon
     */
    public static function getOffset(): Carbon
    {
        /** @var Carbon $offset */
        $offset = Carbon::now()->subHours(12);

        return $offset;
    }
}
