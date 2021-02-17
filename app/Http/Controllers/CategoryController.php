<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show()
    {
        return response()->json(
            CategoryResource::collection(
                Category::whereNull('parent_id')->get()
            )
        );
    }

    public function find(Request $request, int $id)
    {
        return response()->json(
            CategoryResource::make(
                Category::with('children')->findOrFail($id)
            )
        );
    }
}
