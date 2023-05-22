<?php

declare(strict_types=1);

namespace Tiendanube\Test\Auth;

use Tiendanube\Test\BaseTestCase;
use Tiendanube\Test\Context;

final class SessionTest extends BaseTestCase
{
    public function testSessionGetterAndSetterFunctions()
    {
        $session = new Session('12345', 'my_access_token', 'read_products');

        $this->assertEquals('12345', $session->getStoreId());
        $this->assertEquals('my_access_token', $session->getAccessToken());
        $this->assertEquals('read_products', $session->getScope());
    }

    public function testIsValidReturnsTrue()
    {
        Context::$scopes = new Scopes('read_products');

        $session = new Session('12345', 'my_access_token', 'read_products');

        $this->assertTrue($session->isValid());
    }

    public function testIsValidReturnsFalseIfScopesHaveChanged()
    {
        Context::$scopes = new Scopes('read_products,write_orders');

        $session = new Session('12345', 'my_access_token', 'read_products');

        $this->assertFalse($session->isValid());
    }

    public function testIsValidReturnsFalseIfSessionIsCreatedWithoutScopes()
    {
        Context::$scopes = new Scopes('read_products,write_orders');

        $session = new Session('12345', 'my_access_token', '');

        $this->assertFalse($session->isValid());
    }

    public function testIsValidReturnsTrueIfSessionScopesAreUpdated()
    {
        Context::$scopes = new Scopes('read_products,write_orders');

        $session = new Session('12345', 'my_access_token', '');
        $session->setScope('write_orders,,,read_products,');

        $this->assertTrue($session->isValid());
    }
}
