<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_submit_feedback(): void
    {
        $payload = [
            'rating' => 5,
            'product' => 'Falooda',
            'comment' => 'Fresh and delicious.',
            'customer_name' => 'Test Customer',
        ];

        $this->postJson('/feedback', $payload)
            ->assertCreated()
            ->assertJson(['message' => 'Feedback saved successfully']);

        $this->assertDatabaseHas('feedback', $payload);
    }

    public function test_invalid_feedback_is_rejected_without_being_saved(): void
    {
        $this->postJson('/feedback', [
            'rating' => 0,
            'comment' => 'Bad',
        ])->assertUnprocessable();

        $this->assertDatabaseCount('feedback', 0);
    }
}
