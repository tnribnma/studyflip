@extends('layouts.app')
@section('title', '404 - Page Not Found')

@push('styles')
<style>
    .error-wrapper {
        min-height: calc(100vh - 130px);
        display: flex; align-items: center; justify-content: center;
        text-align: center;
        background: linear-gradient(135deg, #f0f4ff, #f8fafc);
    }
    .error-num {
        font-family: 'Syne', sans-serif;
        font-size: clamp(5rem, 18vw, 12rem);
        font-weight: 800;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
    }
    .error-box {
        max-width: 480px;
    }
</style>
@endpush

@section('content')
<div class="error-wrapper py-5">
    <div class="error-box">
        <div class="error-num">404</div>
        <div style="font-size: 3rem">🔍</div>
        <h2 class="fw-bold mt-2">Page Not Found</h2>
        <p class="text-muted">
            Oops! The page you're looking for doesn't exist or has been moved.
            Don't worry, it happens to the best of us!
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
            <a href="{{ route('home') }}" class="btn btn-primary px-4">
                <i class="bi bi-house me-2"></i>Go Home
            </a>
            @if(session('user_id'))
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary px-4">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary px-4">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
