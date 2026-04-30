@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(79,70,229,.07);
        display: flex; align-items: center; gap: 1rem;
    }
    .stat-icon {
        width: 56px; height: 56px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; flex-shrink: 0;
    }
    .stat-num  { font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 800; line-height: 1; }
    .stat-label{ font-size: .82rem; color: #64748b; margin-top: .2rem; }

    .deck-mini {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 1.25rem;
        transition: transform .2s, box-shadow .2s;
        text-decoration: none; color: inherit;
        display: block;
    }
    .deck-mini:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(79,70,229,.13);
        color: inherit;
    }
    .deck-dot {
        width: 12px; height: 12px; border-radius: 50%; display: inline-block;
    }
    .dot-blue   { background: #3b82f6; }
    .dot-green  { background: #10b981; }
    .dot-purple { background: #8b5cf6; }
    .dot-orange { background: #f97316; }
    .dot-red    { background: #ef4444; }
    .dot-teal   { background: #14b8a6; }

    .welcome-banner {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-radius: 20px; padding: 2rem 2.5rem;
        color: #fff; margin-bottom: 2rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem;
    }
    .welcome-banner h2 { font-size: 1.7rem; margin: 0; }
    .welcome-banner p  { opacity: .85; margin: .3rem 0 0; }
</style>
@endpush

@section('content')
<div class="container py-4">

    {{-- Welcome Banner --}}
    <div class="welcome-banner">
        <div>
            <h2>Hello, {{ session('user_name') }}! </h2>
            <p>Ready to study? Here's your progress overview.</p>
        </div>
        <a href="{{ route('decks.create') }}" class="btn btn-warning fw-bold">
            <i class="bi bi-plus-circle me-1"></i> New Deck
        </a>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#ede9fe"><img src="/images/icon_deck.jpg" alt="" style="width:36px;height:36px;"></div>
                <div>
                    <div class="stat-num">{{ $totalDecks }}</div>
                    <div class="stat-label">Total Decks</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#d1fae5"><img src="/images/icon_card.jpg" alt="" style="width:36px;height:36px;"></div>
                <div>
                    <div class="stat-num">{{ $totalCards }}</div>
                    <div class="stat-label">Total Cards</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef3c7"><img src="/images/icon_study_session.jpg" alt="" style="width:36px;height:36px;"></div>
                <div>
                    <div class="stat-num">{{ $totalSessions }}</div>
                    <div class="stat-label">Study Sessions</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Decks --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Recent Decks</h5>
        <a href="{{ route('decks.index') }}" class="text-primary small fw-semibold">View all →</a>
    </div>

    @if($recentDecks->isEmpty())
        <div class="text-center py-5 bg-white rounded-4 border">
            <div style="font-size:3rem"></div>
            <h6 class="fw-bold mt-2">No decks yet</h6>
            <p class="text-muted small">Create your first deck to get started!</p>
            <a href="{{ route('decks.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Create Deck
            </a>
        </div>
    @else
        <div class="row g-3">
            @foreach($recentDecks as $deck)
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('decks.show', $deck) }}" class="deck-mini">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="deck-dot dot-{{ $deck->color }}"></span>
                            <span class="fw-bold text-truncate">{{ $deck->title }}</span>
                        </div>
                        <div class="text-muted small">{{ $deck->cards_count }} cards</div>
                        <div class="mt-2">
                            <a href="{{ route('decks.study', $deck) }}"
                               class="btn btn-sm btn-primary w-100"
                               onclick="event.stopPropagation()">
                                <i class="bi bi-play-fill me-1"></i>Study
                            </a>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
