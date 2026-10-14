@extends('layouts.admin')

@section('title', 'Products | 5Rose Admin')

@section('content')
<div class="mx-auto max-w-[1500px] px-4 py-7 sm:px-6 lg:px-9 lg:py-9">
    <div class="flex flex-col justify-between gap-6 xl:flex-row xl:items-end mb-8">
        <div>
            <span class="text-[10px] font-extrabold tracking-[.18em] text-[#0b8152]">MENU MANAGEMENT</span>
            <h1 class="mt-3 text-4xl font-black tracking-[-.055em] text-[#092c20] sm:text-5xl">Products</h1>
        </div>
        <a href="{{ route('admin.products.create') }}" class="min-h-12 rounded-2xl bg-[#092c20] px-6 py-3 text-sm font-extrabold text-white transition hover:bg-[#071d16] inline-flex items-center">
            + New Product
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex gap-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-1 gap-4">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search products..." class="min-h-12 flex-1 rounded-2xl border border-gray-200 px-4 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none">
            <select name="category" class="min-h-12 rounded-2xl border border-gray-200 px-4 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="min-h-12 rounded-2xl bg-gray-100 px-6 font-bold text-gray-700 hover:bg-gray-200 transition">Filter</button>
        </form>
    </div>

    <div class="overflow-hidden rounded-[24px] border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-[#f4f7f4] text-xs font-bold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-6 py-5">Product</th>
                    <th class="px-6 py-5">Category</th>
                    <th class="px-6 py-5">Price</th>
                    <th class="px-6 py-5">Visibility</th>
                    <th class="px-6 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="transition hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ $product->image_url }}" class="h-12 w-12 rounded-xl object-cover border border-gray-200/60 bg-gray-50 shadow-2xs" alt="{{ $product->name }}" onerror="this.src='{{ asset('images/5rose/logo.png') }}';">
                            <strong class="text-[#092c20]">{{ $product->name }}</strong>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium">{{ $product->category->name }}</td>
                    <td class="px-6 py-4 font-bold text-[#08784b]">Rs. {{ number_format($product->price, 2) }}</td>
                    <td class="px-6 py-4 space-x-1">
                        @if($product->is_available)
                            <span class="rounded-full bg-emerald-100 px-2 py-1 text-[9px] font-bold text-emerald-700">Stock</span>
                        @else
                            <span class="rounded-full bg-red-100 px-2 py-1 text-[9px] font-bold text-red-700">Out</span>
                        @endif
                        @if($product->show_on_pos)
                            <span class="rounded-full bg-blue-100 px-2 py-1 text-[9px] font-bold text-blue-700">POS</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center rounded-xl border border-gray-200 px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-50">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center rounded-xl bg-red-50 px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-100" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        No products found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
