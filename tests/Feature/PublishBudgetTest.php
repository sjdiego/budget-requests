<?php

namespace Tests\Feature;

use App\Budget;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishBudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_publish_pending_budget()
    {
        $budget = factory(Budget::class)->make();
        $user = factory(User::class)->make();

        $response = $this->postJson(
            route('budget.create'),
            [
                'title' => $budget->title,
                'category_id' => $budget->category_id,
                'status_id' => Budget::STATUS_PENDING,
                'description' => $budget->description,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
            ]
        );

        $budgetId = $response->getOriginalContent()->resource->id;

        $this->postJson(
            route('budget.publish', ['id' => $budgetId])
        )->isSuccessful();

        $this->assertDatabaseHas(
            'budgets',
            [
                'id' => $budgetId,
                'status_id' => Budget::STATUS_PUBLISHED
            ]
        );
    }

    public function test_failure_on_publishing_invalid_budget()
    {
        $budget = factory(Budget::class)->make();
        $user = factory(User::class)->make();

        $response = $this->postJson(
            route('budget.create'),
            [
                'status_id' => Budget::STATUS_PENDING,
                'description' => $budget->description,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
            ]
        );

        $budgetId = $response->getOriginalContent()->resource->id;

        $result = $this->postJson(
            route('budget.publish', ['id' => $budgetId])
        );

        $result->assertStatus(422);
    }

    public function test_failure_on_publishing_unexisting_budget()
    {
        $result = $this->postJson(
            route('budget.publish', ['id' => 9999])
        );

        $result->assertStatus(404);
    }

    public function test_failure_on_publishing_already_published_budget()
    {
        $budget = factory(Budget::class)->make();
        $user = factory(User::class)->make();

        $response = $this->postJson(
            route('budget.create'),
            [
                'status_id' => Budget::STATUS_PUBLISHED,
                'description' => $budget->description,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
            ]
        );

        $budgetId = $response->getOriginalContent()->resource->id;

        $result = $this->postJson(
            route('budget.publish', ['id' => $budgetId])
        );

        $result->assertStatus(422);
    }
}
