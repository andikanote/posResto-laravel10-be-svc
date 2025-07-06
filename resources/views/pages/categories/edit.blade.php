@extends('layouts.app')

@section('title', 'Edit Product Category')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <style>
        .image-container {
            margin: 15px 0;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border: 1px solid #eee;
            border-radius: 4px;
            padding: 5px;
        }
        .image-label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            color: #34395e;
        }
        .image-replacement {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px dashed #e4e6fc;
        }
        .file-requirements {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 5px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Product Category</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('categories.index') }}">Product Categories</a></div>
                    <div class="breadcrumb-item">Edit Category</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>Update Category Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            name="name"
                                            value="{{ old('name', $category->name) }}"
                                            placeholder="Enter category name"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Category Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            name="description"
                                            placeholder="Describe this category (optional)"
                                            rows="4">{{ old('description', $category->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="image-container">
                                            @if($category->image)
                                                <span class="image-label">Current Category Image</span>
                                                <img src="{{ asset($category->image) }}"
                                                    alt="Current category image display"
                                                    class="image-preview"
                                                    id="current-image">
                                            @else
                                                <span class="image-label">No image currently set for this category</span>
                                            @endif
                                        </div>

                                        <div class="image-replacement">
                                            <span class="image-label">Update Category Image</span>
                                            <input type="file"
                                                class="form-control @error('image') is-invalid @enderror"
                                                name="image"
                                                id="image-upload"
                                                accept="image/jpeg,image/png,image/jpg,image/svg">
                                            @error('image')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="file-requirements">
                                                <i class="fas fa-info-circle"></i> Recommended: 500x500px JPG/PNG/JPEG/SVG format (Max 2MB)
                                            </div>

                                            <div id="new-image-preview" style="display: none;">
                                                <span class="image-label">New Image Preview</span>
                                                <img id="preview-image" class="image-preview" alt="Preview of new category image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Discard Changes</a>
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
    <script>
        $(document).ready(function() {
            // Image preview for new upload
            $('#image-upload').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        $('#preview-image').attr('src', event.target.result);
                        $('#new-image-preview').show();

                        // Visual indication that this will replace current image
                        if ($('#current-image').length) {
                            $('#current-image').css('opacity', '0.6');
                            $('#current-image').css('border', '1px dashed #ff6b6b');
                        }
                    }

                    reader.readAsDataURL(file);
                } else {
                    $('#new-image-preview').hide();
                    $('#current-image').css('opacity', '1');
                    $('#current-image').css('border', '1px solid #eee');
                }
            });
        });
    </script>
@endpush
