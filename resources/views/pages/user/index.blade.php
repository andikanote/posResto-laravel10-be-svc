@extends('layouts.app')

@section('title', 'Users')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Users</h1>
                <div class="section-header-button">
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Add New Users</a>
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
                                <div class="float-left">
                                    <select class="form-control selectric">
                                        <option>Action For Selected</option>
                                        <option>Move to Draft</option>
                                        <option>Move to Pending</option>
                                        <option>Delete Pemanently</option>
                                    </select>
                                </div>
                                <div class="float-right">
                                    <form method="GET" action="{{ route('user.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search by name or email"
                                                name="search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Roles</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                @php
                                                    // Konversi waktu ke GMT+7
                                                    $createdAt = \Carbon\Carbon::parse($user->created_at)->setTimezone('Asia/Jakarta');
                                                    $updatedAt = \Carbon\Carbon::parse($user->updated_at)->setTimezone('Asia/Jakarta');
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-primary view-user-detail"
                                                           data-id="{{ $user->id }}"
                                                           data-toggle="modal"
                                                           data-target="#userDetailModal"
                                                           style="text-decoration: none;">
                                                            {{ $user->name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone ?? '-' }}</td>
                                                    <td>{{ ucfirst(strtolower($user->roles)) }}</td>
                                                    <td>
                                                        <span title="{{ $createdAt->format('Y-m-d H:i:s') }} WIB">
                                                            {{ $createdAt->diffForHumans() }}
                                                        </span>
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $createdAt->format('d M Y, H:i') }} WIB
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <span title="{{ $updatedAt->format('Y-m-d H:i:s') }} WIB">
                                                            {{ $updatedAt->diffForHumans() }}
                                                        </span>
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $updatedAt->format('d M Y, H:i') }} WIB
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="{{ route('user.edit', $user->id) }}"
                                                                class="btn btn-sm btn-info btn-icon">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>

                                                            <form action="{{ route('user.destroy', $user->id) }}"
                                                                method="POST" class="ml-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button
                                                                    class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                    <i class="fas fa-times"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
    <div class="modal fade" tabindex="-1" role="dialog" id="userDetailModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name:</label>
                        <p id="detail-name" class="form-control-static"></p>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <p id="detail-email" class="form-control-static"></p>
                    </div>
                    <div class="form-group">
                        <label>Phone:</label>
                        <p id="detail-phone" class="form-control-static"></p>
                    </div>
                    <div class="form-group">
                        <label>Role:</label>
                        <p id="detail-role" class="form-control-static"></p>
                    </div>
                    <div class="form-group">
                        <label>Created At:</label>
                        <p id="detail-created" class="form-control-static"></p>
                    </div>
                    <div class="form-group">
                        <label>Updated At:</label>
                        <p id="detail-updated" class="form-control-static"></p>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-users.js') }}"></script>

    <script>
        $(document).ready(function() {
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
                        $('#detail-role').text(response.roles.charAt(0) + response.roles.slice(1).toLowerCase());
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
                    },
                    error: function(xhr) {
                        alert('Error fetching user details');
                    }
                });
            });
        });
    </script>
@endpush
