<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Ambil semua data kategori
        return response()->json($categories, 200); // Kembalikan dalam format JSON
    }
}
