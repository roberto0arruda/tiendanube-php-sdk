<?php

class MockResponse
{
    public $status_code;
    public $body;
    public $headers;
    public $success;

    public function __construct($status_code, $body, $headers)
    {
        $this->status_code = $status_code;
        $this->body = $body;
        $this->headers = $headers;

        $this->success = is_numeric($status_code) && $status_code >= 200 && $status_code < 300;
    }

}