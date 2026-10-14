<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->when($request->category, function ($q, $category) {
                $q->where('category_id', $category);
            })
            ->orderBy('sort_order')
            ->paginate(20);
            
        $categories = Category::orderBy('sort_order')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'required|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        $validated['is_available'] = $request->has('is_available');
        $validated['show_on_pos'] = $request->has('show_on_pos');
        $validated['show_on_website'] = $request->has('show_on_website');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('sort_order')->get();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'required|integer',
        ]);

        $validated['is_available'] = $request->has('is_available');
        $validated['show_on_pos'] = $request->has('show_on_pos');
        $validated['show_on_website'] = $request->has('show_on_website');

        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
