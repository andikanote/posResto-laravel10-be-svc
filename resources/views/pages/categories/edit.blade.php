@extends('layouts.app')

@section('title', 'Edit Category')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/dist/sweetalert2.min.css') }}">
    <style>
        .form-section {
            margin-bottom: 30px;
        }
        .form-header {
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border: 1px solid #eee;
            border-radius: 4px;
            padding: 5px;
        }
        .file-requirements {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        .current-image-label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Category</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></div>
                    <div class="breadcrumb-item">Edit Category</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit Category Details</h2>
                <p class="section-lead">
                    Update the category information below. Changes will be reflected across all associated products.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-section">
                                        <div class="form-header">
                                            <h4>Basic Information</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label>Category Name <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name"
                                                        value="{{ old('name', $category->name) }}"
                                                        required>
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                                        name="description"
                                                        rows="3">{{ old('description', $category->description) }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section">
                                        <div class="form-header">
                                            <h4>Category Image</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                @if($category->image)
                                                    <div class="current-image-container mb-4">
                                                        <span class="current-image-label">Current Image</span>
                                                        <img src="{{ asset($category->image) }}"
                                                            alt="Current category image"
                                                            class="image-preview"
                                                            id="current-image">
                                                    </div>
                                                @else
                                                    <div class="alert alert-light">
                                                        <i class="fas fa-info-circle"></i> No image currently set for this category
                                                    </div>
                                                @endif

                                                <div class="form-group">
                                                    <label>Update Image</label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="custom-file-input @error('image') is-invalid @enderror"
                                                            id="customFile"
                                                            name="image"
                                                            accept="image/jpeg,image/png,image/jpg">
                                                        <label class="custom-file-label" for="customFile">Choose new image...</label>
                                                        @error('image')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="file-requirements">
                                                        <i class="fas fa-info-circle"></i> Recommended: 500x500px JPG/PNG format (Max 2MB)
                                                    </div>

                                                    <div id="new-image-preview" class="mt-3" style="display: none;">
                                                        <span class="current-image-label">New Image Preview</span>
                                                        <img id="preview-image" class="image-preview" alt="Preview of new image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                    <a href="{{ route('categories.index') }}" class="btn btn-light ml-2">
                                        <i class="fas fa-arrow-left"></i> Cancel
                                    </a>
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
    <script src="{{ asset('library/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            // Custom file input label update
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);

                // Show preview of new image
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        $('#preview-image').attr('src', event.target.result);
                        $('#new-image-preview').show();

                        // Visual indication that this will replace current image
                        if ($('#current-image').length) {
                            $('#current-image').css('opacity', '0.6');
                            $('#current-image').css('border', '2px dashed #ff6b6b');
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
