<?php

class MockRequests
{
    private $response;
    public $args;

    public function __construct($body, $status_code = 200, $headers = [])
    {
        $this->response = new MockResponse($status_code, $body, $headers);
    }

    public function __call($method, $args)
    {
        $this->args = $args;

        return $this->response;
    }
}