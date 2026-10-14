@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Category | 5Rose Admin' : 'New Category | 5Rose Admin')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-7 sm:px-6 lg:px-9 lg:py-9">
    <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-emerald-700 mb-6 inline-block">← Back to Categories</a>
    
    <div class="overflow-hidden rounded-[30px] border border-gray-200 bg-white shadow-sm p-6 sm:p-8">
        <h1 class="text-3xl font-black tracking-[-.04em] text-[#092c20] mb-8">
            {{ isset($category) ? 'Edit Category' : 'Create New Category' }}
        </h1>

        <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($category)) @method('PUT') @endif

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition">
                @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Emoji Icon (optional)</label>
                <input type="text" name="icon" value="{{ old('icon', $category->icon ?? '') }}" placeholder="🍹" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition">
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }} class="h-5 w-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <label for="is_active" class="text-sm font-bold text-gray-700">Active / Visible on POS</label>
            </div>

            <div class="pt-6 border-t border-gray-100">
                <button type="submit" class="rounded-xl bg-[#08784b] px-6 py-3 text-sm font-extrabold text-white transition hover:bg-[#06633e]">
                    {{ isset($category) ? 'Update Category' : 'Save Category' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
