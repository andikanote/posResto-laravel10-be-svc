@extends('layouts.app')

@section('title', 'Product Management')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/dist/sweetalert2.min.css') }}">
    <style>
        .badge-active {
            background-color: #28a745;
            color: white;
        }
        .badge-inactive {
            background-color: #dc3545;
            color: white;
        }
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
        .product-image {
            max-width: 60px;
            max-height: 60px;
            border-radius: 4px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Product Management</h1>
                <div class="section-header-button">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Products</div>
                    <div class="breadcrumb-item">Product List</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Product Management</h2>
                <p class="section-lead">
                    Manage your product inventory, including adding new products, updating details, and monitoring stock levels.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Product List</h4>
                            </div>
                            <div class="card-body">
                                <div class="filter-container">
                                    <!-- Status Filter -->
                                    <div class="filter-group">
                                        <form method="GET" action="{{ route('products.index') }}" id="status-filter-form">
                                            <select class="form-control selectric" name="status" onchange="this.form.submit()">
                                                <option value="">Filter by Status</option>
                                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </form>
                                    </div>

                                    <!-- Search Box -->
                                    <div class="filter-group search-box">
                                        <form method="GET" action="{{ route('products.index') }}">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control"
                                                    placeholder="Search by product name..."
                                                    name="search"
                                                    value="{{ request('search') }}"
                                                    aria-label="Search products">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="fas fa-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Reset Filters -->
                                    @if(request('status') || request('search'))
                                    <div class="filter-group">
                                        <a href="{{ route('products.index') }}" class="btn btn-light">
                                            <i class="fas fa-sync-alt"></i> Clear Filters
                                        </a>
                                    </div>
                                    @endif
                                </div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Price (IDR)</th>
                                            <th>Status</th>
                                            <th>Stock Level</th>
                                            <th>Date Added</th>
                                            <th>Actions</th>
                                        </tr>
                                        @forelse ($products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>
                                                    @if($product->image)
                                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                                                    @else
                                                        <span class="text-muted">No image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $product->category->name }}</td>
                                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                                <td>
                                                    <span class="badge {{ $product->status == 1 ? 'badge-active' : 'badge-inactive' }}">
                                                        {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>{{ $product->stock }}</td>
                                                <td>{{ $product->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('products.edit', $product->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('products.destroy', $product->id) }}"
                                                            method="POST" class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No products found matching your criteria</td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </div>
                                <div class="float-right mt-3">
                                    {{ $products->withQueryString()->links() }}
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
@endpush
