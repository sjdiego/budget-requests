<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('users', $user->toArray());
    }
}
