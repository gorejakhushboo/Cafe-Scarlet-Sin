@extends('admin.layout')

@section('content')
<h2 class="admin-title" style="margin-bottom: 1.5rem;">Edit Category: {{ $category->name }}</h2>

@if ($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.categories.update', $category->id) }}" method="POST" style="background: rgba(14, 13, 13, 0.6); padding: 2rem; border-radius: 15px; border: 1px solid var(--antique-gold);">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-input" id="name" name="name" value="{{ old('name', $category->name) }}" required>
    </div>
    <div class="form-group">
        <label for="slug" class="form-label">Slug (URL identifier)</label>
        <input type="text" class="form-input" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required>
    </div>
    <div class="form-group">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-textarea" id="description" name="description">{{ old('description', $category->description) }}</textarea>
    </div>
    <div class="form-group">
        <label for="display_order" class="form-label">Display Order</label>
        <input type="number" class="form-input" id="display_order" name="display_order" value="{{ old('display_order', $category->display_order) }}">
    </div>
    <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
        <label class="form-label" for="is_active" style="margin: 0;">Active</label>
    </div>
    <div style="margin-top: 2rem;">
        <button type="submit" class="submit-btn" style="margin-right: 1rem;">Update Category</button>
        <a href="{{ route('admin.categories.index') }}" class="action-btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
