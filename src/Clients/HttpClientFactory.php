<?php

declare(strict_types=1);

namespace Tiendanube\Clients;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;

class HttpClientFactory
{
    /**
     * @codeCoverageIgnore This is mocked for tests
     */
    public function client(): Client
    {
        return new Client();
    }
}
