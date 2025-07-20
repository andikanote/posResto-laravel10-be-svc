@extends('layouts.app')

@section('title', 'Users')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <style>
        .btn[disabled] {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .locked-user {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Users</h1>
                <div class="section-header-button">
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Add New User</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Users</a></div>
                    <div class="breadcrumb-item">All Users</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Users Management</h2>
                <p class="section-lead">
                    You can manage all Users, such as editing, deleting and more.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Users</h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="float-left">
                                    <select class="form-control selectric" id="role-filter">
                                        <option value="">All Roles</option>
                                        <option value="ADMIN" {{ request('role') == 'ADMIN' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="STAFF" {{ request('role') == 'STAFF' ? 'selected' : '' }}>Staff
                                        </option>
                                        <option value="USER" {{ request('role') == 'USER' ? 'selected' : '' }}>User
                                        </option>
                                    </select>
                                </div>
                                <div class="float-right">
                                    <form method="GET" action="{{ route('user.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search by name or email"
                                                name="search" value="{{ request('search') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="align-middle">Name</th>
                                                <th class="align-middle">Email</th>
                                                <th class="align-middle">Phone</th>
                                                <th class="align-middle">Roles</th>
                                                <th class="align-middle">Created At</th>
                                                <th class="align-middle">Updated At</th>
                                                <th class="text-center align-middle">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($users as $user)
                                                @php
                                                    $createdAt = \Carbon\Carbon::parse($user->created_at)->setTimezone(
                                                        'Asia/Jakarta',
                                                    );
                                                    $updatedAt = \Carbon\Carbon::parse($user->updated_at)->setTimezone(
                                                        'Asia/Jakarta',
                                                    );
                                                    $isLocked = $loop->first; // Lock first row
                                                @endphp
                                                <tr class="{{ $isLocked ? 'locked-user' : '' }}">
                                                    <td class="align-middle">
                                                        <a href="#"
                                                            class="text-primary font-weight-bold view-user-detail"
                                                            data-id="{{ $user->id }}" data-toggle="modal"
                                                            data-target="#userProfileModal"
                                                            data-user-id="{{ $user->id }}"
                                                            style="text-decoration: none;">
                                                            {{ $user->name }}
                                                            @if ($isLocked)
                                                                <i class="fas fa-lock ml-1 text-muted"
                                                                    title="This user is locked"></i>
                                                            @endif
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">{{ $user->email }}</td>
                                                    <td class="align-middle">{{ $user->phone ?? '-' }}</td>
                                                    <td class="align-middle">
                                                        <span
                                                            class="badge
                                                            @if ($user->roles === 'ADMIN') badge-primary
                                                            @elseif($user->roles === 'STAFF') badge-warning
                                                            @elseif($user->roles === 'USER') badge-success
                                                            @else badge-secondary @endif">
                                                            {{ ucfirst(strtolower($user->roles)) }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="text-sm text-muted">{{ $createdAt->format('d M Y') }}</span>
                                                            <small class="text-muted">{{ $createdAt->format('H:i') }}
                                                                WIB</small>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="text-sm text-muted">{{ $updatedAt->format('d M Y') }}</span>
                                                            <small class="text-muted">{{ $updatedAt->format('H:i') }}
                                                                WIB</small>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="d-flex justify-content-center">
                                                            @if ($isLocked)
                                                                <button class="btn btn-sm btn-info btn-icon mr-2" disabled
                                                                    title="This user cannot be edited">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-danger btn-icon" disabled
                                                                    title="This user cannot be deleted">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @else
                                                                <a href="{{ route('user.edit', $user->id) }}"
                                                                    class="btn btn-sm btn-info btn-icon mr-2">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('user.destroy', $user->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button
                                                                        class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No users found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $users->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- User Detail Modal -->
    <!-- Modal -->
    <div class="modal fade" id="userProfileModal" tabindex="-1" role="dialog" aria-labelledby="userProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userProfileModalLabel">Profil Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBodyContent">
                    <!-- Konten akan dimuat via AJAX di sini -->
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" tabindex="-1" role="dialog" id="userDetailModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="detail-name"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="detail-email"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="detail-phone"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <span class="badge" id="detail-role-badge">
                                <span id="detail-role"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Created At</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="detail-created"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Updated At</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="detail-updated"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}

@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
        $('#userProfileModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var userId = button.data('user-id'); // Ekstrak info dari data-* atribut
            var modal = $(this);

            // Load konten via AJAX
            $.get('/profile/modal/' + userId, function(data) {
                modal.find('#modalBodyContent').html(data);
            }).fail(function() {
                modal.find('#modalBodyContent').html('<div class="alert alert-danger">Gagal memuat profil pengguna.</div>');
            });
        });
    });
        $(document).ready(function() {
            // Initialize selectric
            $('.selectric').selectric();

            // Show success alert if exists
            @if (session('success'))
                swal({
                    title: 'Success',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    timer: 3000,
                    buttons: false
                });
            @endif

            // Role filter functionality
            $('#role-filter').on('change', function() {
                var role = $(this).val();
                var url = new URL(window.location);

                if (role) {
                    url.searchParams.set('role', role);
                } else {
                    url.searchParams.delete('role');
                }

                // Remove page parameter to go back to first page
                url.searchParams.delete('page');

                window.location.href = url.toString();
            });

            // Delete confirmation
            $(document).on('click', '.confirm-delete', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                swal({
                        title: 'Are you sure?',
                        text: 'Once deleted, you will not be able to recover this user!',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });
            });

            // View User Details when clicking on name
            $('.view-user-detail').on('click', function(e) {
                e.preventDefault();
                var userId = $(this).data('id');

                // AJAX request to get user details
                $.ajax({
                    url: '/user/' + userId,
                    type: 'GET',
                    success: function(response) {
                        // Format dates
                        var createdAt = new Date(response.created_at);
                        var updatedAt = new Date(response.updated_at);

                        // Set modal content
                        $('#detail-name').text(response.name);
                        $('#detail-email').text(response.email);
                        $('#detail-phone').text(response.phone || '-');

                        // Set role badge
                        var roleBadge = $('#detail-role-badge');
                        roleBadge.removeClass().addClass('badge');
                        if (response.roles === 'ADMIN') {
                            roleBadge.addClass('badge-primary');
                        } else if (response.roles === 'STAFF') {
                            roleBadge.addClass('badge-warning');
                        } else if (response.roles === 'USER') {
                            roleBadge.addClass('badge-success');
                        } else {
                            roleBadge.addClass('badge-secondary');
                        }
                        $('#detail-role').text(response.roles.charAt(0) + response.roles.slice(
                            1).toLowerCase());

                        $('#detail-created').text(createdAt.toLocaleString('en-US', {
                            timeZone: 'Asia/Jakarta',
                            weekday: 'short',
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            timeZoneName: 'short'
                        }));

                        $('#detail-updated').text(updatedAt.toLocaleString('en-US', {
                            timeZone: 'Asia/Jakarta',
                            weekday: 'short',
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            timeZoneName: 'short'
                        }));

                        // Show the modal
                        $('#userDetailModal').modal('show');
                    },
                    error: function(xhr) {
                        swal('Error', 'Failed to fetch user details', 'error');
                    }
                });
            });
        });
    </script>
@endpush
