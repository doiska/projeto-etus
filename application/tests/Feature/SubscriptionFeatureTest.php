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
