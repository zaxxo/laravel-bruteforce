<?php

namespace Zaxxo\LaravelBruteforce;

use Exception;

/**
 * An exception which must be thrown if the response should be throttled.
 *
 * @package Zaxxo\LaravelBruteforce
 */
class ThrottledException extends Exception
{
    /**
     * The response to return.
     *
     * @var mixed
     */
    protected $response;

    /**
     * ThrottledException constructor.
     *
     * @param mixed $response
     */
    public function __construct($response)
    {
        parent::__construct();

        $this->response = $response;
    }

    /**
     * Get the response to return.
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}
