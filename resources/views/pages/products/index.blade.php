@extends('layouts.app')

@section('title', 'Product Management')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/dist/sweetalert2.min.css') }}">
    <style>
        /* Status Badges */
        .badge-active {
            background-color: #28a745;
            color: white;
        }
        .badge-inactive {
            background-color: #dc3545;
            color: white;
        }

        /* Filter Styles */
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

        /* Product Image */
        .product-image {
            max-width: 60px;
            max-height: 60px;
            border-radius: 4px;
        }

        /* Statistics Cards */
        .card-statistic-1 {
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 120px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .card-statistic-1:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .card-statistic-1 .card-icon {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 60px;
            height: 60px;
            font-size: 24px;
            line-height: 60px;
            text-align: center;
            border-radius: 50%;
        }
        .card-statistic-1 .card-wrap {
            padding: 20px 20px 20px 90px;
        }
        .card-statistic-1 .card-header h4 {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .card-statistic-1 .card-body {
            font-size: 24px;
            font-weight: 700;
            color: #34395e;
            margin-bottom: 5px;
        }
        .card-statistic-1 .card-statistic-detail {
            padding: 10px 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            border-radius: 0 0 8px 8px;
        }
        .card-statistic-1 .card-statistic-detail .text-small {
            font-size: 12px;
            color: #6c757d;
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

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Products</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalProducts) }}
                                </div>
                            </div>
                            <div class="card-statistic-detail">
                                <span class="text-small">All products in inventory</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Active Products</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($activeProducts) }}
                                </div>
                            </div>
                            <div class="card-statistic-detail">
                                <span class="text-small">{{ $totalProducts > 0 ? number_format($activeProducts/$totalProducts*100, 1) : 0 }}% of total</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-cubes"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Stock</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalStock) }}
                                </div>
                            </div>
                            <div class="card-statistic-detail">
                                <span class="text-small">Items available</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product List -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Product List</h4>
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

                                <!-- Filters -->
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
                                                <input type="text" class="form-control" placeholder="Search by product name..."
                                                       name="search" value="{{ request('search') }}" aria-label="Search products">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="fas fa-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Reset Filters -->
                                    @if (request('status') || request('search'))
                                        <div class="filter-group">
                                            <a href="{{ route('products.index') }}" class="btn btn-light">
                                                <i class="fas fa-sync-alt"></i> Clear Filters
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Table -->
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
                                                    @if ($product->image)
                                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                             class="product-image">
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
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('products.destroy', $product->id) }}"
                                                              method="POST" class="ml-2"
                                                              id="delete-form-{{ $product->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                                    data-id="{{ $product->id }}">
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

        // SweetAlert for delete confirmation
        $(document).on('click', '.confirm-delete', function(e) {
            e.preventDefault();
            let productId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#delete-form-${productId}`).submit();
                }
            });
        });
    </script>
@endpush
