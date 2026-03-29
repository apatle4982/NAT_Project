<?php

namespace App\Controller\Api;

use Cake\Core\Exception\Exception;
use Psr\Http\Message\ResponseInterface;

class ResponseException extends Exception
{
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct('Short-circuit response', $response->getStatusCode());
        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}