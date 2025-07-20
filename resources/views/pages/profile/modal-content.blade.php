<div class="row">
    <div class="col-md-4">
        <div class="text-center">
            <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('img/default-avatar.png') }}"
                 class="rounded-circle img-thumbnail mb-3"
                 width="120"
                 alt="{{ $user->name }}">
        </div>
        <h4 class="text-center">{{ $user->name }}</h4>
        <div class="text-center">
            <span class="badge badge-{{ $user->roles == 'Admin' ? 'danger' : 'primary' }}">
                {{ $user->roles ?? 'User' }}
            </span>
        </div>
        <hr>
        <p><i class="fas fa-calendar-alt mr-2"></i> Bergabung: {{ $user->created_at->format('d M Y') }}</p>
    </div>
    <div class="col-md-8">
        <div class="mb-3">
            <h5><i class="fas fa-envelope mr-2"></i> Email</h5>
            <p>{{ $user->email }}</p>
        </div>

        @if($user->phone)
        <div class="mb-3">
            <h5><i class="fas fa-phone mr-2"></i> Telepon</h5>
            <p>{{ $user->phone }}</p>
        </div>
        @endif

        <div class="mb-3">
            <h5><i class="fas fa-info-circle mr-2"></i> Bio</h5>
            <div class="border p-3 rounded">
                {!! $profile->bio ?? '<span class="text-muted">Tidak ada deskripsi</span>' !!}
            </div>
        </div>
    </div>
</div>
