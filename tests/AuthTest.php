<?php

class AuthTest extends \PHPUnit\Framework\TestCase
{
    private $auth;

    public function setUp(): void
    {
        $this->auth = new TiendaNube\Auth(1, 'qwertyuiop');
    }

    /**
     * @throws \TiendaNube\Auth\Exception
     */
    public function testRequestAccessTokenSuccess(): void
    {
        $mock = new MockRequests(
            '{"access_token":"abcdefabcdef","token_type":"bearer","scope":"write_products,write_customers","user_id":"123"}'
        );
        $this->auth->requests = $mock;

        $store_info = $this->auth->request_access_token('abc123');

        //Request
        $this->assertEquals('https://www.tiendanube.com/apps/authorize/token', $mock->args[0]);

        $this->assertArrayHasKey('client_id', $mock->args[2]);
        $this->assertEquals(1, $mock->args[2]['client_id']);

        $this->assertArrayHasKey('client_secret', $mock->args[2]);
        $this->assertEquals('qwertyuiop', $mock->args[2]['client_secret']);

        $this->assertArrayHasKey('client_id', $mock->args[2]);
        $this->assertEquals('abc123', $mock->args[2]['code']);

        $this->assertArrayHasKey('grant_type', $mock->args[2]);
        $this->assertEquals('authorization_code', $mock->args[2]['grant_type']);

        //Response
        $this->assertArrayHasKey('store_id', $store_info);
        $this->assertEquals(123, $store_info['store_id']);

        $this->assertArrayHasKey('access_token', $store_info);
        $this->assertEquals('abcdefabcdef', $store_info['access_token']);

        $this->assertArrayHasKey('scope', $store_info);
        $this->assertEquals('write_products,write_customers', $store_info['scope']);
    }

    public function testLoginUrls(): void
    {
        $this->assertEquals('https://www.nuvemshop.com.br/apps/1/authorize', $this->auth->login_url_brazil());
        $this->assertEquals('https://www.tiendanube.com/apps/1/authorize', $this->auth->login_url_spanish());
    }

    /**
     * @expectedException TiendaNube\Auth\Exception
     */
    public function testRequestAccessTokenExpired(): void
    {
        $this->auth->requests = new MockRequests(
            '{"error":"invalid_grant","error_description":"The authorization code has expired"}'
        );
        $this->auth->request_access_token('abc123');
    }

    /**
     * @expectedException TiendaNube\Auth\Exception
     */
    public function testRequestAccessTokenError(): void
    {
        $this->auth->requests = new MockRequests('{}', 500);
        $this->auth->request_access_token('abc123');
    }
}