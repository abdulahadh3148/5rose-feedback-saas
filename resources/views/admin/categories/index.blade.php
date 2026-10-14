@extends('layouts.admin')

@section('title', 'Categories | 5Rose Admin')

@section('content')
<div class="mx-auto max-w-[1500px] px-4 py-7 sm:px-6 lg:px-9 lg:py-9">
    <div class="flex flex-col justify-between gap-6 xl:flex-row xl:items-end mb-8">
        <div>
            <span class="text-[10px] font-extrabold tracking-[.18em] text-[#0b8152]">PRODUCT MANAGEMENT</span>
            <h1 class="mt-3 text-4xl font-black tracking-[-.055em] text-[#092c20] sm:text-5xl">Categories</h1>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="min-h-12 rounded-2xl bg-[#092c20] px-6 py-3 text-sm font-extrabold text-white transition hover:bg-[#071d16] inline-flex items-center">
            + New Category
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-red-100 bg-red-50 px-5 py-4 text-sm font-semibold text-red-800">
            × {{ session('error') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-[24px] border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-[#f4f7f4] text-xs font-bold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-6 py-5">Sort</th>
                    <th class="px-6 py-5">Icon</th>
                    <th class="px-6 py-5">Name</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                <tr class="transition hover:bg-gray-50">
                    <td class="px-6 py-4 font-bold">{{ $category->sort_order }}</td>
                    <td class="px-6 py-4 text-2xl">{{ $category->icon }}</td>
                    <td class="px-6 py-4 font-bold text-[#092c20]">{{ $category->name }}</td>
                    <td class="px-6 py-4">
                        @if($category->is_active)
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-bold text-emerald-700">Active</span>
                        @else
                            <span class="rounded-full bg-gray-100 px-3 py-1 text-[10px] font-bold text-gray-500">Disabled</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center rounded-xl border border-gray-200 px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-50">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center rounded-xl bg-red-50 px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-100" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        No categories found. Create one to get started.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
