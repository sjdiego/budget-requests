<?php

namespace Tests\Feature;

use App\Budget;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscardBudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_discard_pending_budget()
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
            route('budget.discard', ['id' => $budgetId])
        );

        $result->assertStatus(200);
    }

    public function test_discard_published_budget()
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
            route('budget.discard', ['id' => $budgetId])
        );

        $result->assertStatus(200);
    }

    public function test_failure_on_discard_already_discarded_budget()
    {
        $budget = factory(Budget::class)->make();
        $user = factory(User::class)->make();

        $response = $this->postJson(
            route('budget.create'),
            [
                'description' => $budget->description,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
            ]
        );

        $budgetId = $response->getOriginalContent()->resource->id;

        Budget::find($budgetId)->update(['status_id' => Budget::STATUS_DISCARDED]);

        $result = $this->postJson(
            route('budget.discard', ['id' => $budgetId])
        );

        $result->assertStatus(422);
    }

    public function test_failure_on_discard_unexisting_budget()
    {
        $result = $this->postJson(
            route('budget.discard', ['id' => 9999])
        );

        $result->assertStatus(404);
    }
}
