@extends('layouts.app')
@section('title', 'My Profile')

@push('styles')
<style>
    .profile-avatar {
        width: 80px; height: 80px; border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif; font-size: 2rem;
        font-weight: 800; color: #fff;
    }
    .stat-pill {
        background: #f0f4ff; border-radius: 10px;
        padding: .6rem 1.2rem; text-align: center;
    }
    .stat-pill .num  { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.6rem; color: #4f46e5; }
    .stat-pill .lbl  { font-size: .78rem; color: #64748b; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-person-circle me-2"></i>My Profile</h1>
        <p>Manage your account and settings</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body p-4 text-center">
                    <div class="profile-avatar mx-auto mb-3">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
                    <p class="text-muted small">{{ $user->email }}</p>
                    <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                        {{ ucfirst($user->role) }}
                    </span>

                    <hr>
                    <div class="d-flex gap-2 justify-content-center">
                        <div class="stat-pill">
                            <div class="num">{{ $totalDecks }}</div>
                            <div class="lbl">Decks</div>
                        </div>
                        <div class="stat-pill">
                            <div class="num">{{ $totalSessions }}</div>
                            <div class="lbl">Sessions</div>
                        </div>
                    </div>

                    <p class="text-muted small mt-3 mb-0">
                        Member since {{ $user->created_at->format('M Y') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">

            <div class="card mb-4">
                <div class="card-header">👤 Edit Profile Information</div>
                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->hasBag('default'))
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->getBag('default')->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" novalidate>
                        @csrf @method('PUT')

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="bi bi-check-circle me-1"></i>Save Changes
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">🔒 Change Password</div>
                <div class="card-body p-4">

                    @if($errors->has('current_password'))
                        <div class="alert alert-danger">{{ $errors->first('current_password') }}</div>
                    @endif

                    <form action="{{ route('profile.password') }}" method="POST" novalidate>
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="Enter your current password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Min. 6 characters" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation"
                                       class="form-control" placeholder="Repeat new password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning mt-3">
                            <i class="bi bi-shield-lock me-1"></i>Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
