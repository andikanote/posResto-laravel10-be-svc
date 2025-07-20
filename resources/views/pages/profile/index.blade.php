@extends('layouts.app')

@section('title', 'Profil Pengguna')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profil Pengguna</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Profil Saya</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Hai, {{ $user->name }}!</h2>
                <p class="section-lead">
                    Kelola informasi profil Anda untuk memastikan data selalu terbaru.
                </p>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    </div>
                @endif

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-5">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <div class="profile-widget-items">
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Bergabung Pada</div>
                                        <div class="profile-widget-item-value">
                                            @if ($user->created_at)
                                                {{ $user->created_at->translatedFormat('j F Y') }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Status Akun</div>
                                        <div class="profile-widget-item-value">
                                            <span class="badge badge-success">Aktif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-widget-description pb-4">
                                <div class="profile-widget-name">
                                    {{ $user->name }}
                                    <div class="text-muted d-inline font-weight-normal">
                                        @if ($user->roles)
                                            @php
                                                $roleClass = 'badge-primary'; // Default class
                                                if ($user->roles == 'Admin') {
                                                    $roleClass = 'badge-danger';
                                                } elseif ($user->roles == 'Editor') {
                                                    $roleClass = 'badge-warning';
                                                } elseif ($user->roles == 'Author') {
                                                    $roleClass = 'badge-info';
                                                }
                                            @endphp
                                            <span class="badge {{ $roleClass }}">{{ $user->roles }}</span>
                                        @else
                                            <span class="badge badge-secondary">Pengguna</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3">
                                    {!! $profile->bio ?? '<p class="text-muted font-italic">Anda belum menambahkan deskripsi profil.</p>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-7">
                        <div class="card">
                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                                class="needs-validation" novalidate>
                                @csrf
                                <div class="card-header">
                                    <h4>Edit Profil</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12 col-12">
                                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $user->name) }}" required>
                                            <div class="invalid-feedback">
                                                Silakan isi nama lengkap Anda
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-7 col-12">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email', $user->email) }}" required>
                                            <div class="invalid-feedback">
                                                Harap masukkan alamat email yang valid
                                            </div>
                                        </div>
                                        <div class="form-group col-md-5 col-12">
                                            <label>Nomor Telepon/WhatsApp</label>
                                            <input type="tel" name="phone" class="form-control"
                                                value="{{ old('phone', $user->phone) }}"
                                                placeholder="Contoh: 081234567890">
                                            <small class="text-muted">Format: 08xxxxxxxxxx</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Deskripsi Profil</label>
                                            <textarea name="bio" class="form-control summernote-simple"
                                                placeholder="Tuliskan deskripsi singkat tentang diri Anda...">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                    </button>
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
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/bs-custom-file-input/dist/bs-custom-file-input.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            // Summernote
            $('.summernote-simple').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol', 'paragraph']]
                ],
                placeholder: 'Tuliskan deskripsi singkat tentang diri Anda...'
            });

            // Custom file input
            bsCustomFileInput.init();

            // Tooltip
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
