<?php

declare(strict_types=1);

namespace App\Tests\Functional;

final class HomeTest extends FunctionalTestCase
{
    public function testSuccess(): void
    {
        $this->client->request('GET', '/api');

        $response = $this->client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertEquals([
            'version' => '1.0'
        ], json_decode($response->getContent(), true));
    }
}
