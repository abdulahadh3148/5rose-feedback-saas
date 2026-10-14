@extends('layouts.admin')

@section('title', isset($product) ? 'Edit Product | 5Rose Admin' : 'New Product | 5Rose Admin')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-7 sm:px-6 lg:px-9 lg:py-9">
    <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-emerald-700 mb-6 inline-block">← Back to Products</a>
    
    <div class="overflow-hidden rounded-[30px] border border-gray-200 bg-white shadow-sm p-6 sm:p-8">
        <h1 class="text-3xl font-black tracking-[-.04em] text-[#092c20] mb-8">
            {{ isset($product) ? 'Edit Product' : 'Create New Product' }}
        </h1>

        <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($product)) @method('PUT') @endif

            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition">
                </div>
                
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Category</label>
                    <select name="category_id" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Price (Rs.)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Product Image</label>
                @if(isset($product))
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ $product->image_url }}" class="h-20 w-20 rounded-2xl object-cover border border-gray-200 shadow-xs" alt="{{ $product->name }}">
                        <span class="text-xs text-gray-500 font-medium">Current image (upload new file to replace)</span>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            </div>

            <div class="space-y-3 bg-[#f4f7f4] p-5 rounded-2xl">
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_available" value="1" id="is_available" {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }} class="h-5 w-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="is_available" class="text-sm font-bold text-gray-700">In Stock</label>
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="show_on_pos" value="1" id="show_on_pos" {{ old('show_on_pos', $product->show_on_pos ?? true) ? 'checked' : '' }} class="h-5 w-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="show_on_pos" class="text-sm font-bold text-gray-700">Show on POS</label>
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="show_on_website" value="1" id="show_on_website" {{ old('show_on_website', $product->show_on_website ?? true) ? 'checked' : '' }} class="h-5 w-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="show_on_website" class="text-sm font-bold text-gray-700">Show on Website Menu</label>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100">
                <button type="submit" class="rounded-xl bg-[#08784b] px-8 py-3 text-sm font-extrabold text-white transition hover:bg-[#06633e]">
                    {{ isset($product) ? 'Update Product' : 'Save Product' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
