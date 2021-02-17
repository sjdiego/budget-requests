<?php

namespace Tests\Feature;

use App\Budget;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateBudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_new_budget()
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

        $response
            ->assertSuccessful()
            ->assertJsonFragment(
                [
                    'title' => $budget->title,
                    'description' => $budget->description,
                    'status' => $budget->statusLabel
                ]
            );
    }

    public function test_failure_on_create_budget_without_userdata()
    {
        $budget = factory(Budget::class)->make();

        $response = $this->postJson(
            route('budget.create'),
            [
                'title' => $budget->title,
                'category_id' => $budget->category_id,
                'status_id' => Budget::STATUS_PENDING,
                'description' => $budget->description,
            ]
        );

        $response->assertStatus(422);
    }

    public function test_failure_on_create_budget_with_wrong_email()
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
                'email' => 'asdsdfsddsggdgffdgs',
                'phone' => $user->phone,
                'address' => $user->address,
            ]
        );

        $response->assertStatus(422);
    }

    public function test_create_budget_and_modify_info_of_existing_user()
    {
        $faker = Factory::create();

        $budget = factory(Budget::class)->make();
        $user = factory(User::class)->create();

        $fakedData = [
            'phone' => $faker->phoneNumber,
            'address' => $faker->address
        ];

        $this->postJson(
            route('budget.create'),
            [
                'title' => $budget->title,
                'category_id' => $budget->category_id,
                'status_id' => Budget::STATUS_PENDING,
                'description' => $budget->description,
                'email' => $user->email,
                'phone' => $fakedData['phone'],
                'address' => $fakedData['address'],
            ]
        )->isSuccessful();

        $this->assertDatabaseHas(
            'users',
            [
                'email' => $user->email,
                'phone' => $fakedData['phone'],
                'address' => $fakedData['address'],
            ]
        );
    }
}
