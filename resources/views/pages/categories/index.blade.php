@extends('layouts.app')

@section('title', 'Category Management')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/dist/sweetalert2.min.css') }}">
    <style>
        .filter-group {
            margin-bottom: 15px;
        }

        .filter-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .search-box {
            min-width: 250px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Category Management</h1>
                <div class="section-header-button">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Categories</div>
                    <div class="breadcrumb-item">Category List</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Category Management</h2>
                <p class="section-lead">
                    Organize your product categories, including adding new categories and updating existing ones.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Category List</h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="filter-container">
                                    <!-- Search Box -->
                                    <div class="filter-group search-box">
                                        <form method="GET" action="{{ route('categories.index') }}">
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    placeholder="Search by category name..." name="name"
                                                    value="{{ request('name') }}" aria-label="Search categories">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="fas fa-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Reset Filters -->
                                    @if (request('name'))
                                        <div class="filter-group">
                                            <a href="{{ route('categories.index') }}" class="btn btn-light">
                                                <i class="fas fa-sync-alt"></i> Clear Filters
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Category Name</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                        @forelse ($categories as $category)
                                            <tr>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('categories.edit', $category->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('categories.destroy', $category->id) }}"
                                                            method="POST" class="ml-2"
                                                            id="delete-form-{{ $category->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                                data-id="{{ $category->id }}">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No categories found matching your criteria</td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </div>
                                <div class="float-right mt-3">
                                    {{ $categories->withQueryString()->links() }}
                                </div>
                            </div>
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
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script>
        // SweetAlert for success messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 1000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @endif
    </script>
@endpush
