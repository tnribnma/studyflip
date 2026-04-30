@extends('layouts.app')
@section('title', 'Login')

@push('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 70px);
        display: flex; align-items: center;
        background: linear-gradient(135deg, #f0f4ff 0%, #f8fafc 100%);
    }
    .auth-card {
        max-width: 440px; width: 100%; margin: 0 auto;
        background: #fff; border-radius: 20px;
        box-shadow: 0 8px 40px rgba(79,70,229,.12);
        padding: 2.5rem;
    }
    .auth-logo {
        font-family: 'Syne', sans-serif; font-size: 1.8rem;
        font-weight: 800; color: #4f46e5;
        text-align: center; margin-bottom: .25rem;
    }
    .auth-logo span { color: #f59e0b; }
    .demo-box {
        background: #f0fdf4; border: 1px solid #bbf7d0;
        border-radius: 10px; padding: .75rem 1rem;
        font-size: .83rem; color: #166534;
    }
</style>
@endpush

@section('content')
<div class="auth-wrapper py-5">
    <div class="container">
        <div class="auth-card">
            <div class="auth-logo">Study<span>Flip</span></div>
            <h4 class="text-center fw-bold mb-1">Welcome back</h4>
            <p class="text-center text-muted small mb-4">Sign in to continue studying</p>

            {{-- Demo credentials --}}
            <div class="demo-box mb-4">
                <strong>Demo:</strong> demo@studyflip.com / password
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="email">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="you@example.com"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password"
                               class="form-control" placeholder="Your password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePass">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
            </form>

            <hr class="my-4">
            <p class="text-center text-muted small mb-0">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-primary fw-semibold">Sign up free</a>
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
        p.type = p.type === 'password' ? 'text' : 'password';
        icon.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    });
</script>
@endpush
