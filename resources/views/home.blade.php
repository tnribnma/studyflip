@extends('layouts.app')

@section('title', 'Welcome')

@push('styles')
<style>
    .hero {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #3730a3 100%);
        min-height: 88vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .hero::before {
        content: '';
        position: absolute;
        width: 600px; height: 600px;
        background: rgba(255,255,255,.05);
        border-radius: 50%;
        top: -200px; right: -100px;
    }
    .hero::after {
        content: '';
        position: absolute;
        width: 400px; height: 400px;
        background: rgba(245,158,11,.1);
        border-radius: 50%;
        bottom: -100px; left: -100px;
    }
    .hero-content { position: relative; z-index: 2; }
    .hero h1 {
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
        letter-spacing: -1px;
    }
    .hero h1 span { color: #fbbf24; }
    .hero p {
        color: rgba(255,255,255,.85);
        font-size: 1.2rem;
        max-width: 480px;
        line-height: 1.7;
    }
    .hero-card {
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 20px;
        padding: 2rem;
        color: #fff;
    }
    .flip-demo {
        width: 240px; height: 150px;
        perspective: 1000px;
        margin: 0 auto 1rem;
        cursor: pointer;
    }
    .flip-inner {
        width: 100%; height: 100%;
        position: relative;
        transform-style: preserve-3d;
        transition: transform .6s ease;
        border-radius: 14px;
    }
    .flip-demo:hover .flip-inner,
    .flip-demo.flipped .flip-inner { transform: rotateY(180deg); }
    .flip-front, .flip-back {
        position: absolute; inset: 0;
        backface-visibility: hidden;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.1rem;
        padding: 1rem; text-align: center;
    }
    .flip-front { background: #fff; color: #4f46e5; }
    .flip-back  { background: #fbbf24; color: #1e293b; transform: rotateY(180deg); }

    .feature-card {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 24px rgba(79,70,229,.08);
        transition: transform .2s, box-shadow .2s;
        height: 100%;
    }
    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(79,70,229,.16);
    }
    .feature-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; margin-bottom: 1rem;
    }

    .steps-section { background: #fff; padding: 5rem 0; }
    .step-num {
        width: 48px; height: 48px;
        background: #4f46e5; color: #fff;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.1rem;
        margin: 0 auto 1rem;
    }
</style>
@endpush

@section('content')

<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 hero-content">
                <h1>Study Smarter with <span>Flashcards</span></h1>
                <p class="mt-3 mb-4">
                    Create decks, flip cards, and master any subject.
                    StudyFlip makes memorization simple and effective.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-warning btn-lg fw-bold px-4">
                        <i class="bi bi-rocket-takeoff me-2"></i>Start for Free
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                        Sign In
                    </a>
                </div>
            </div>
            <div class="col-lg-5 hero-content">
                <div class="hero-card text-center">
                    <p class="mb-2 opacity-75" style="font-size:.85rem">HOVER TO FLIP</p>
                    <div class="flip-demo" id="heroCard">
                        <div class="flip-inner">
                            <div class="flip-front">
                                <div>
                                    <div style="font-size:2rem"></div>
                                    <div><img src="/images/icon-question.svg" alt="" style="width:32px;height:32px;"></div>
                                    What is StudyFlip?
                                </div>
                            </div>
                            <div class="flip-back">
                                <div>
                                    <div style="font-size:2rem"></div>
                                    <div><img src="/images/icon-celebrate.svg" alt="" style="width:32px;height:32px;"></div>
                                    Your #1 flashcard study tool!
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0" style="font-size:.9rem; opacity:.8"><img src="/images/icon-sparkle.svg" alt="" style="width:14px;height:14px;margin-right:4px;vertical-align:middle;filter:brightness(0) invert(1);opacity:0.8;">
                        ✨ Flip cards to reveal answers
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 mt-2">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="font-size:2.2rem; font-weight:800">Everything you need to learn</h2>
            <p class="text-muted">Simple tools, powerful results</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:#ede9fe"><img src="/images/icon-decks.svg" alt="Decks" style="width:28px;height:28px;"></div>
                    <h5 class="fw-bold">Organize in Decks</h5>
                    <p class="text-muted mb-0">Group your flashcards into decks by subject, topic, or chapter. Stay organized.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:#d1fae5"><img src="/images/icon-flip.svg" alt="Flip" style="width:28px;height:28px;"></div>
                    <h5 class="fw-bold">Interactive Flip Mode</h5>
                    <p class="text-muted mb-0">Tap any card to flip and reveal the answer. Study at your own pace.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:#fef3c7"><img src="/images/icon-stats.svg" alt="Stats" style="width:28px;height:28px;"></div>
                    <h5 class="fw-bold">Track Progress</h5>
                    <p class="text-muted mb-0">See how many sessions you've completed and how many cards you've mastered.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="steps-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="font-size:2.2rem; font-weight:800">How it works</h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="step-num">1</div>
                <h6 class="fw-bold">Sign Up Free</h6>
                <p class="text-muted small">Create your account in seconds</p>
            </div>
            <div class="col-md-3">
                <div class="step-num">2</div>
                <h6 class="fw-bold">Create a Deck</h6>
                <p class="text-muted small">Name it, pick a color, describe it</p>
            </div>
            <div class="col-md-3">
                <div class="step-num">3</div>
                <h6 class="fw-bold">Add Cards</h6>
                <p class="text-muted small">Write questions and answers</p>
            </div>
            <div class="col-md-3">
                <div class="step-num">4</div>
                <h6 class="fw-bold">Study & Flip!</h6>
                <p class="text-muted small">Start flipping and memorize anything</p>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                <i class="bi bi-arrow-right-circle me-2"></i>Get Started Now
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.getElementById('heroCard').addEventListener('click', function() {
        this.classList.toggle('flipped');
    });
</script>
@endpush
