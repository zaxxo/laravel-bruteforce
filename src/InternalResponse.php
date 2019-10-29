<?php

namespace Zaxxo\LaravelBruteforce;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Represent a response if request should be throttled.
 *
 * @package Zaxxo\LaravelBruteforce
 * @internal
 */
class InternalResponse extends Response
{
    /**
     * The original response.
     *
     * @var Response
     */
    private $response;

    /**
     * InternalResponse constructor.
     *
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        parent::__construct();

        $this->response = $response;
    }

    /**
     * Get the original response.
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * No preparation needed here.
     *
     * @param Request $request
     * @return InternalResponse
     */
    public function prepare(Request $request): InternalResponse
    {
        return $this;
    }
}
