@extends('admin.layout')

@section('content')
<h2>Add New Product</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>
    
    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Legacy Category Field (Hidden or Removed? Keeping as hidden for now if DB requires it, but migration didn't remove it) -->
    <!-- We should probably fill it with the category name or slug for backward compatibility if needed, or just ignore it if we updated the code -->
    <!-- For now, I'll auto-fill it with a hidden input based on selection using JS, or just let the controller handle it -->
    <input type="hidden" name="category" id="category_legacy" value="default">

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
    </div>
    
    <div class="mb-3">
        <label for="ingredients" class="form-label">Ingredients</label>
        <textarea class="form-control" id="ingredients" name="ingredients">{{ old('ingredients') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="flavor_notes" class="form-label">Flavor Notes</label>
        <textarea class="form-control" id="flavor_notes" name="flavor_notes">{{ old('flavor_notes') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="origin_story" class="form-label">Origin Story</label>
        <textarea class="form-control" id="origin_story" name="origin_story">{{ old('origin_story') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
    </div>

    <div class="mb-3">
        <label for="special_price" class="form-label">Special Price</label>
        <input type="number" step="0.01" class="form-control" id="special_price" name="special_price" value="{{ old('special_price') }}">
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <div class="mb-2" id="imagePreviewContainer" style="display: none;">
            <img id="imagePreview" src="#" alt="Image Preview" style="max-height: 200px; max-width: 100%; border: 1px solid #ddd; padding: 5px;">
        </div>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        <div class="form-text">Allowed formats: jpg, jpeg, png. Max size: 2MB.</div>
    </div>

    <div class="mb-3 form-check">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>

    <button type="submit" class="btn btn-primary">Create Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
</form>

@endsection
