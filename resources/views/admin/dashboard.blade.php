<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Scarlet Sin | Admin Dashboard</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Bodoni+Moda+SC:wght@400;600;700&family=Great+Vibes&family=Raleway+Dots&family=Quintessential&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dark-academia.css') }}">
    
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--antique-gold);
            padding-bottom: 1rem;
        }
        
        .admin-title {
            color: var(--antique-gold);
            font-family: var(--font-script);
            font-size: 2.5rem;
        }
        
        .admin-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
        }
        
        .product-list {
            background: rgba(14, 13, 13, 0.6);
            border: 1px solid var(--antique-gold);
            border-radius: 15px;
            padding: 1.5rem;
            overflow-x: auto;
        }
        
        .product-form-container {
            background: rgba(14, 13, 13, 0.8);
            border: 1px solid var(--antique-gold);
            border-radius: 15px;
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 2rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            color: var(--parchment);
        }
        
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(184, 134, 11, 0.2);
        }
        
        th {
            color: var(--antique-gold);
            font-family: var(--font-serif);
            font-weight: 600;
        }
        
        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            font-family: var(--font-serif);
            border: none;
            transition: var(--transition-smooth);
            margin-right: 0.5rem;
        }
        
        .edit-btn {
            background: var(--antique-gold);
            color: var(--ink-black);
        }
        
        .delete-btn {
            background: var(--crimson-dark);
            color: var(--parchment);
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            color: var(--antique-gold);
            margin-bottom: 0.5rem;
            font-family: var(--font-serif);
        }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 0.8rem;
            background: rgba(245, 241, 232, 0.1);
            border: 1px solid var(--antique-gold);
            border-radius: 5px;
            color: var(--parchment);
            font-family: var(--font-serif);
        }
        
        .form-select option {
            background-color: #1a0a0a;
            color: var(--parchment);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(45deg, var(--burgundy-deep), var(--crimson-dark));
            color: var(--parchment);
            border: 1px solid var(--antique-gold);
            border-radius: 5px;
            cursor: pointer;
            font-family: var(--font-serif);
            font-weight: bold;
            transition: var(--transition-smooth);
        }
        
        .submit-btn:hover {
            box-shadow: var(--shadow-glow);
        }
        
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            border: 1px solid var(--antique-gold);
        }
        
        .alert-success {
            background: rgba(0, 100, 0, 0.3);
            color: #90EE90;
        }
        
        .alert-error {
            background: rgba(139, 0, 0, 0.3);
            color: #FF6347;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
        }
        
        .status-active {
            background: rgba(0, 128, 0, 0.3);
            color: #90EE90;
        }
        
        .status-inactive {
            background: rgba(128, 0, 0, 0.3);
            color: #FF6347;
        }
    </style>
</head>
<body>
    <header class="header" id="header">
        <nav class="nav-container">
            <a href="{{ route('home') }}" class="logo">Café Scarlet Sin</a>
            <ul class="nav-menu" style="text-transform:uppercase">
                <li><a href="{{ route('home') }}" class="nav-link">The Parlor</a></li>
                <li><a href="{{ route('page2') }}" class="nav-link">The Indulgences</a></li>
                <li><a href="{{ route('page3') }}" class="nav-link">The Scarlet Society</a></li>
                <li><a href="{{ route('admin.products.index') }}" class="nav-link active">Admin</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content" style="padding-top: 100px;">
        <div class="admin-container">
            <div class="admin-header">
                <h1 class="admin-title">Product Management</h1>
                <div>
                    <a href="{{ route('admin.categories.index') }}" class="action-btn edit-btn" style="text-decoration: none;">Manage Categories</a>
                    <button onclick="resetForm()" class="action-btn edit-btn">New Product</button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="admin-grid">
                <!-- Product List -->
                <div class="product-list">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ ucfirst($product->category) }}</td>
                                    <td>
                                        ${{ number_format($product->price, 2) }}
                                        @if($product->special_price)
                                            <br><small style="color: var(--crimson-light)">Special: ${{ number_format($product->special_price, 2) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $product->is_active ? 'status-active' : 'status-inactive' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button onclick="editProduct({{ $product }})" class="action-btn edit-btn">Edit</button>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Product Form -->
                <div class="product-form-container">
                    <h2 id="formTitle" style="color: var(--antique-gold); margin-bottom: 1.5rem;">Add New Product</h2>
                    
                    <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="methodField"></div>

                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select" required onchange="updateLegacyCategory(this)">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" data-name="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="category" id="category_legacy">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Special Price (Optional)</label>
                            <input type="number" step="0.01" name="special_price" id="special_price" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-textarea"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ingredients</label>
                            <textarea name="ingredients" id="ingredients" class="form-textarea"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Flavor Notes</label>
                            <input type="text" name="flavor_notes" id="flavor_notes" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Origin Story</label>
                            <textarea name="origin_story" id="origin_story" class="form-textarea"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Image</label>
                            
                            <!-- Current Image Display (for Edit mode) -->
                            <div id="currentImageContainer" style="display:none; margin-bottom: 10px;">
                                <p style="color:var(--antique-gold); font-size:0.8rem; margin-bottom:5px;">Current Image:</p>
                                <img id="currentImage" src="" style="max-height:100px; border:1px solid var(--antique-gold);">
                            </div>

                            <input type="file" name="image" class="form-input" onchange="previewImage(this)">
                            
                            <!-- New Image Preview -->
                            <div id="imagePreviewContainer" style="margin-top: 10px; display: none;">
                                <p style="color:var(--antique-gold); font-size:0.8rem; margin-bottom:5px;">New Reference:</p>
                                <img id="imagePreview" src="" style="max-height: 200px; border: 1px dashed var(--antique-gold); display: block;">
                            </div>
                        </div>

                        <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label for="is_active" class="form-label" style="margin: 0;">Active</label>
                        </div>

                        <button type="submit" class="submit-btn" id="submitBtn">Create Product</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        function updateLegacyCategory(select) {
            const selectedOption = select.options[select.selectedIndex];
            const legacyName = selectedOption.getAttribute('data-name');
            document.getElementById('category_legacy').value = legacyName || '';
        }

        // Image Preview Logic
        function previewImage(input) {
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');
            const file = input.files[0];

            if (file) {
                // Validation (Type)
                if (!file.type.match('image.*')) {
                    alert('Please select a valid image file!');
                    input.value = '';
                    previewContainer.style.display = 'none';
                    return;
                }
                // Validation (Size 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB.');
                    input.value = '';
                    previewContainer.style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        }

        function editProduct(product) {
            document.getElementById('formTitle').textContent = 'Edit Product: ' + product.name;
            document.getElementById('submitBtn').textContent = 'Update Product';
            
            // Update form action
            const form = document.getElementById('productForm');
            form.action = `/admin/products/${product.id}`;
            
            // Add PUT method
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            // Fill fields
            document.getElementById('name').value = product.name;
            
            // Set category_id
            const categorySelect = document.getElementById('category_id');
            categorySelect.value = product.category_id;
            // Trigger change to update legacy field
            updateLegacyCategory(categorySelect);
            
            document.getElementById('price').value = product.price;
            document.getElementById('special_price').value = product.special_price || '';
            document.getElementById('description').value = product.description || '';
            document.getElementById('ingredients').value = product.ingredients || '';
            document.getElementById('flavor_notes').value = product.flavor_notes || '';
            document.getElementById('origin_story').value = product.origin_story || '';
            document.getElementById('is_active').checked = product.is_active;

            // Handle Image Display
            const currentContainer = document.getElementById('currentImageContainer');
            const currentImg = document.getElementById('currentImage');
            
            // Reset new preview
            document.getElementById('imagePreviewContainer').style.display = 'none';
            document.getElementById('imagePreview').src = '#';

            if (product.image_path) {
                // Assuming images are stored in public/images
                currentImg.src = `/images/${product.image_path}`; 
                currentContainer.style.display = 'block';
            } else {
                currentContainer.style.display = 'none';
            }
            
            // Scroll to form
            document.querySelector('.product-form-container').scrollIntoView({ behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('formTitle').textContent = 'Add New Product';
            document.getElementById('submitBtn').textContent = 'Create Product';
            
            const form = document.getElementById('productForm');
            form.action = "{{ route('admin.products.store') }}";
            form.reset();
            
            document.getElementById('methodField').innerHTML = '';
            
            // Clear Images
            document.getElementById('currentImageContainer').style.display = 'none';
            document.getElementById('imagePreviewContainer').style.display = 'none';
            document.getElementById('imagePreview').src = '';
            document.getElementById('currentImage').src = '';
        }
    </script>
</body>
</html>
