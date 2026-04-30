@extends('layouts.app')
@section('title', 'Create Account')

@push('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #f0f4ff 0%, #f8fafc 100%);
    }
    .auth-card {
        max-width: 480px;
        width: 100%;
        margin: 0 auto;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 40px rgba(79,70,229,.12);
        padding: 2.5rem;
    }
    .auth-logo {
        font-family: 'Syne', sans-serif;
        font-size: 1.8rem;
        font-weight: 800;
        color: #4f46e5;
        text-align: center;
        margin-bottom: .25rem;
    }
    .auth-logo span { color: #f59e0b; }
</style>
@endpush

@section('content')
<div class="auth-wrapper py-5">
    <div class="container">
        <div class="auth-card">
            <div class="auth-logo">Study<span>Flip</span> </div>
            <h4 class="text-center fw-bold mb-1">Create your account</h4>
            <p class="text-center text-muted small mb-4">Start studying smarter today</p>

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label" for="name">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="John Doe"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label" for="email">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="you@example.com"
                               value="{{ old('email') }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 6 characters"
                               required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePass">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="Repeat your password"
                               required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-person-plus me-2"></i>Create Account
                </button>
            </form>

            <hr class="my-4">
            <p class="text-center text-muted small mb-0">
                Already have an account?
                <a href="{{ route('login') }}" class="text-primary fw-semibold">Sign in</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('togglePass').addEventListener('click', function() {
        const p = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (p.type === 'password') {
            p.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            p.type = 'password';
            icon.className = 'bi bi-eye';
        }
    });
</script>
@endpush
