<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Category::with('meditations')->orderBy('name');

        if ($request->has('category_id')) {
            $query->where('id', $request->input('category_id'));
        }

        $categories = $query->get();

        return response()->json([
            'data' => $categories->map(fn (Category $category) => [
                'id' => $category->id,
                'name' => $category->name,
                'meditations' => $category->meditations,
            ]),
        ]);
    }
}
