@extends('layouts.app')

@section('title', 'Edit Product Details')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <style>
        .btn-secondary {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: white;
        }

        .file-error {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
            display: none;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Update Product</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></div>
                    <div class="breadcrumb-item">Edit Product</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Edit Product Details</h2>
                <p class="section-lead">
                    Modify the product details as needed
                </p>

                @if ($errors->any())
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form method="POST" action="{{ route('products.update', $product->id) }}"
                                enctype="multipart/form-data" class="needs-validation" novalidate="">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>Edit Product Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>Product Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" value="{{ old('name', $product->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>Category</label>
                                            <select
                                                class="form-control selectric @error('category_id') is-invalid @enderror"
                                                name="category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>Price</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    name="price_display" id="price"
                                                    value="{{ old('price_display', number_format($product->price, 0, ',', '.')) }}"
                                                    required>
                                                <input type="hidden" name="price" id="price_raw"
                                                    value="{{ old('price', $product->price) }}">
                                            </div>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>Stock Quantity</label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                                name="stock" value="{{ old('stock', $product->stock) }}" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Product Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label class="form-label">Status</label>
                                            <div class="selectgroup selectgroup-pills">
                                                <label class="selectgroup-item">
                                                    <input type="checkbox" name="status" value="1"
                                                        class="selectgroup-input"
                                                        {{ old('status', $product->status) ? 'checked' : '' }}>
                                                    <span class="selectgroup-button">Active</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label class="form-label">Favorite</label>
                                            <div class="selectgroup selectgroup-pills">
                                                <label class="selectgroup-item">
                                                    <input type="checkbox" name="is_favorite" value="1"
                                                        class="selectgroup-input"
                                                        {{ old('is_favorite', $product->is_favorite) ? 'checked' : '' }}>
                                                    <span class="selectgroup-button">Favorite</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Product Image</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('image') is-invalid @enderror"
                                                name="image" id="customFile"
                                                accept="image/jpeg,image/png,image/jpg,image/gif">
                                            <label class="custom-file-label" for="customFile">
                                                @if ($product->image)
                                                    Current image: {{ basename($product->image) }}
                                                @else
                                                    Select new image (JPEG, PNG, JPG - max 2MB)
                                                @endif
                                            </label>
                                        </div>
                                        @if ($product->image)
                                            <div class="mt-2">
                                                <img src="{{ asset($product->image) }}" alt="Current product image"
                                                    style="max-width: 200px;">
                                            </div>
                                        @endif
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div id="fileError" class="file-error">
                                            File size exceeds 2MB limit. Please select a smaller file.
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.id.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-post-create.js') }}"></script>
    @if (session('success'))
        document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 1000, // 3 detik
        timerProgressBar: true,
        showConfirmButton: false
        }).then(() => {
        window.location.href = "{{ route('products.index') }}";
        });
        });
    @endif
    <script>
        // Price formatting and validation
        document.addEventListener('DOMContentLoaded', function() {
            // Price formatting
            const cleave = new Cleave('#price', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                numeralDecimalMark: ',',
                delimiter: '.',
                prefix: '',
                numeralIntegerScale: 10,
                numeralDecimalScale: 0,
                onValueChanged: function(e) {
                    const rawValue = e.target.rawValue.replace(/[^0-9]/g, '');
                    document.getElementById('price_raw').value = rawValue;

                    if (rawValue.length > 10) {
                        const limitedValue = rawValue.substring(0, 10);
                        cleave.setRawValue(limitedValue);
                        document.getElementById('price_raw').value = limitedValue;
                    }
                }
            });

            // Set initial value
            const initialValue = {{ old('price', $product->price) }};
            cleave.setRawValue(initialValue.toString());
            document.getElementById('price_raw').value = initialValue;

            // Form submission handler
            document.querySelector('form').addEventListener('submit', function(e) {
                // Ensure the raw value is submitted as the price
                priceInput.value = priceRawInput.value;
            });

            // File input handling
            document.querySelector('.custom-file-input')?.addEventListener('change', function(e) {
                var fileInput = e.target;
                var fileName = fileInput.files[0]?.name || 'Select file (JPEG, PNG, JPG - max 2MB)';
                var nextSibling = e.target.nextElementSibling;
                nextSibling.innerText = fileName;

                // Check file size
                if (fileInput.files[0]) {
                    var fileSize = fileInput.files[0].size / 1024 / 1024; // in MB
                    var errorElement = document.getElementById('fileError');

                    if (fileSize > 2) {
                        errorElement.style.display = 'block';
                        fileInput.value = ''; // Clear the file input
                        nextSibling.innerText = 'Select file (JPEG, PNG, JPG - max 2MB)';
                        fileInput.classList.add('is-invalid');
                    } else {
                        errorElement.style.display = 'none';
                        fileInput.classList.remove('is-invalid');
                    }
                }
            });

        });
    </script>
@endpush
