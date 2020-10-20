<?php

declare(strict_types=1);

namespace App\Tests\Functional\Auth\SignUp;

use App\Tests\Functional\FunctionalTestCase;

class ConfirmTest extends FunctionalTestCase
{
    private const URI = '/api/sign-up/confirm';

    public function testSuccess(): void
    {
        $this->client->request('POST', self::URI . '/success_token', [], [], ['CONTENT_TYPE' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertSame(204, $response->getStatusCode());
    }

    public function testNotValid(): void
    {
        $this->client->request('POST', self::URI . '/not_valid_token', [], [], ['CONTENT_TYPE' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertSame(419, $response->getStatusCode());
        $this->assertEquals([
            'message' => 'Incorrect or confirmed token.'
        ], json_decode($response->getContent(), true));
    }
}
