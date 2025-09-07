<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Display all products
    public function view()
    {
        $products = Product::all();
        return view('admin.viewProduct', compact('products'));
    }
    // Show add product form
    public function create()
    {
        return view('admin.addProduct');
    }
    // Handle form submission
    public function store(Request $request)
    {
        try {
            $data = new Product();
            $image = $request->file('image');
            if ($image) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $data->image = $imageName;
            }

            $data->name = $request->name;
            $data->category = $request->category;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->quantity = $request->quantity;
            $data->save();


            return redirect()->route('admin.viewProduct')->with('success', '✅ Product added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ An error occurred: ' . $e->getMessage());
        }
    }

    // Show edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.editProduct', compact('product'));
    }

    // Handle update
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $product->image = $imageName;
            }

            $product->name = $request->name;
            $product->category = $request->category;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->save();

            return redirect()->route('admin.viewProduct')->with('success', '✅ Product updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Update failed: ' . $e->getMessage());
        }
    }

    // Delete product
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('admin.viewProduct')->with('success', '🗑️ Product deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Delete failed: ' . $e->getMessage());
        }
    }

    public function orderItem()
    {
        
        return view('admin.order');
    }
}