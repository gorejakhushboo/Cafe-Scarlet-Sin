@extends('admin.layout')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">Categories</h1>
    <div>
        <a href="{{ route('admin.products.index') }}" class="action-btn" style="background: var(--coffee-light); color: var(--parchment); text-decoration: none;">Back to Products</a>
        <a href="{{ route('admin.categories.create') }}" class="action-btn edit-btn">Add New Category</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Display Order</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>{{ $category->display_order }}</td>
            <td>
                @if($category->is_active)
                    <span style="color: #90EE90;">Active</span>
                @else
                    <span style="color: #FF6347;">Inactive</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="action-btn edit-btn">Edit</a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="action-btn delete-btn" onclick="return confirm('Delete this category?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
