<?php

use Tests\TestCase;

class SubscriptionFeatureTest extends TestCase
{
    public function testMissingFields()
    {
        $response = $this->postJson(
            '/api/subscribe',
            [],
            [
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]
        );

        $response->assertStatus(422);
    }

    public function testInvalidEmail()
    {
        $invalidEmail = "email_invalido";

        $response = $this->postJson(
            '/api/subscribe',
            [
                "email" => $invalidEmail
            ],
            [
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing("subscribers", [
            "email" => $invalidEmail
        ]);
    }

    public function testDuplicatedEmail()
    {
        $email = fake()->safeEmail();

        $this->assertDatabaseMissing("subscribers", [
            "email" => $email
        ]);

        $response = $this->postJson(
            '/api/subscribe',
            [
                "email" => $email
            ],
            [
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]
        );

        $response->assertStatus(201);

        $this->assertDatabaseHas("subscribers", [
            "email" => $email
        ]);

        $duplicatedResponse = $this->postJson(
            '/api/subscribe',
            [
                "email" => $email
            ],
            [
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]
        );

        $duplicatedResponse->assertStatus(422);
    }

    public function testSuccessfulSubscription()
    {
        $email = fake()->safeEmail();

        $response = $this->postJson(
            '/api/subscribe',
            [
                "email" => $email
            ],
            [
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]
        );

        $response->assertStatus(201);

        $this->assertDatabaseHas("subscribers", [
            "email" => $email
        ]);
    }
}
