<?php

namespace Tests\Feature;

use App\Budget;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetBudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_list_of_budgets()
    {
        $response = $this->getJson(route('budget.list'));

        $response->assertSuccessful();
    }
}
