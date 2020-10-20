<?php

declare(strict_types=1);

namespace App\Tests\Functional\Auth\SignUp;

use App\Tests\Functional\FunctionalTestCase;

final class RequestTest extends FunctionalTestCase
{
    private const URI = '/api/sign-up';

    public function testSuccess(): void
    {
        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'login' => 'userLogin',
            'email' => $email = 'user@app.test',
            'password' => 'secret',
            'age' => 25
        ]));

        $response = $this->client->getResponse();

        $this->assertSame(201, $response->getStatusCode());
        $this->assertEquals([
            'email' => $email
        ], json_decode($response->getContent(), true));
    }

    public function testValidationErrors(): void
    {
        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'login' => '',
            'email' => 'wrong',
            'password' => '',
            'age' => 4
        ]));

        $response = $this->client->getResponse();

        $this->assertSame(422, $response->getStatusCode());
        $this->assertArraySubset([
            'violations' => [
                ['propertyPath' => 'login', 'title' => 'This value should not be blank.'],
                ['propertyPath' => 'login', 'title' => 'This value is too short. It should have 4 characters or more.'],
                ['propertyPath' => 'email', 'title' => 'This value is not a valid email address.'],
                ['propertyPath' => 'password', 'title' => 'This value should not be blank.'],
                ['propertyPath' => 'password', 'title' => 'This value is too short. It should have 5 characters or more.'],
                ['propertyPath' => 'age', 'title' => 'This value should be greater than or equal to 7.']
            ],
        ], json_decode($response->getContent(), true));
    }

    public function testLoginAlreadyExists(): void
    {
        $this->testSuccess();

        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'login' => 'userLogin',
            'email' => 'email@app.test',
            'password' => 'secret',
            'age' => 25
        ]));

        $response = $this->client->getResponse();

        $this->assertEquals([
            'message' => 'User with this login already exists.',
        ], json_decode($response->getContent(), true));
    }

    public function testEmailAlreadyExists(): void
    {
        $this->testSuccess();

        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'login' => 'testUserLogin',
            'email' => 'user@app.test',
            'password' => 'secret',
            'age' => 25
        ]));

        $response = $this->client->getResponse();

        $this->assertEquals([
            'message' => 'User with this email already exists.',
        ], json_decode($response->getContent(), true));
    }
}
