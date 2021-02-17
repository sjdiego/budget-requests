<?php

namespace Tests\Unit;

use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_category()
    {
        $category = factory(Category::class)->create();

        $this->assertDatabaseHas('categories', $category->toArray());
    }
}
