<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Construcción',
            'slug' => 'contruccion',
            'description' => 'Descripcion de la categoría'
        ]);
        Category::create([
            'name' => 'Reformas',
            'slug' => 'reformas',
            'description' => 'Descripcion de la categoría'
        ]);
        Category::create([
            'name' => 'Instaladores',
            'slug' => 'instaladores',
            'description' => 'Descripcion de la categoría'
        ]);

        factory(Category::class, 15)->create()->each(
            function ($category) {
                $category->parent()->save(factory(Category::class)->make());
            }
        );
    }
}
