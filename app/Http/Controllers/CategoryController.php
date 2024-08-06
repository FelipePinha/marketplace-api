<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        return response()->json([
            'status' => true,
            'category' => $category->load('products'),
        ], 200);
    }
}