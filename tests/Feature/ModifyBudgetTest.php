<?php

namespace Tests\Feature;

use App\Budget;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModifyBudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_and_modify_budget()
    {
        $faker = Factory::create();
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

        $newData = [
            'title' => $faker->words(4, true),
            'description' => $faker->paragraph(1)
        ];

        $this->putJson(
            route('budget.edit', ['id' => $budgetId]),
            [
                'title' => $newData['title'],
                'description' => $newData['description'],
            ]
        )->isSuccessful();

        $this->assertDatabaseHas(
            'budgets',
            [
                'id' => $budgetId,
                'title' => $newData['title'],
                'description' => $newData['description'],
            ]
        );
    }
}
