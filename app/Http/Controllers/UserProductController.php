<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    /**
     * Show user dashboard with all products + categories
     */
    public function dashboard()
    {
        // Get all products
        $products = Product::latest()->get();

        // Get distinct categories
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('user.dashboard', compact('products', 'categories'));
    }

    /**
     * Show products filtered by category
     */
    public function byCategory($category)
    {
        $products = Product::where('category', $category)->get();
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('user.products.index', compact('products', 'categories', 'category'));

    }

    /**
     * Show single product details
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('user.products.show', compact('product', 'categories'));
    }
    /**
     * Show all products without filtering
     */
    public function allProducts()
    {
        $products = Product::all();
        $categories = Product::select('category')->distinct()->pluck('category');
        $category = null; // ✅ no specific category when showing all
        return view('user.products.index', compact('products', 'categories', 'category'));
    }
    /**
     * Searching products by name or category
     */
    public function search(Request $request)
{
    $query = $request->input('q');

    if (!$query) {
        // If search box is empty, return all products
        $products = Product::all();
    } else {
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('category', 'LIKE', "%{$query}%")
            ->get();
    }

    $categories = Product::select('category')->distinct()->pluck('category');

    return view('user.products.index', compact('products', 'categories'))
        ->with('searchQuery', $query);
}

}