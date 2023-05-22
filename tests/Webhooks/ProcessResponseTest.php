<?php

declare(strict_types=1);

namespace Tiendanube\Test\Webhooks;

use Tiendanube\Test\BaseTestCase;
use Tiendanube\Webhooks\ProcessResponse;

final class ProcessResponseTest extends BaseTestCase
{
    public function testGetters()
    {
        $response = new ProcessResponse(true);
        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getErrorMessage());

        $response = new ProcessResponse(false, 'Something went wrong');
        $this->assertFalse($response->isSuccess());
        $this->assertEquals('Something went wrong', $response->getErrorMessage());
    }
}
