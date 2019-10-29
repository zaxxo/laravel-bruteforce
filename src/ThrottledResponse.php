<?php

namespace Zaxxo\LaravelBruteforce;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;

/**
 * Represent a throttled response.
 *
 * @package Zaxxo\LaravelBruteforce
 */
class ThrottledResponse implements Responsable
{
    /**
     * The original response.
     *
     * @var InternalResponse
     */
    private $response;

    /**
     * ThrottledResponse constructor.
     *
     * @param mixed $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     * @return InternalResponse
     * @internal
     */
    public function toResponse($request): InternalResponse
    {
        $response = Router::toResponse($request, $this->response);

        return new InternalResponse($response);
    }

    /**
     * Create throttled response with status code.
     *
     * @param int $status
     * @return ThrottledResponse
     */
    public static function withStatus(int $status): ThrottledResponse
    {
        return new static(new Response('', $status));
    }
}
