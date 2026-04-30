@extends('layouts.app')
@section('title', 'My Decks')

@push('styles')
<style>
    .deck-card {
        background: #fff; border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 12px rgba(79,70,229,.06);
        overflow: hidden; height: 100%;
        transition: transform .2s, box-shadow .2s;
    }
    .deck-card:hover { transform: translateY(-4px); box-shadow: 0 12px 36px rgba(79,70,229,.14); }
    .deck-color-bar { height: 6px; }
    .bar-blue   { background: #3b82f6; }
    .bar-green  { background: #10b981; }
    .bar-purple { background: #8b5cf6; }
    .bar-orange { background: #f97316; }
    .bar-red    { background: #ef4444; }
    .bar-teal   { background: #14b8a6; }
    .deck-body  { padding: 1.25rem; }
    .deck-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.05rem; }
    .deck-actions { display: flex; gap: .5rem; margin-top: 1rem; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1><i class="bi bi-collection me-2"></i>My Decks</h1>
                <p>All your flashcard decks in one place</p>
            </div>
            <a href="{{ route('decks.create') }}" class="btn btn-warning fw-bold">
                <i class="bi bi-plus-circle me-2"></i>New Deck
            </a>
        </div>
    </div>
</div>

<div class="container pb-5">

    @if($decks->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:4rem">📭</div>
            <h5 class="fw-bold mt-3">You have no decks yet</h5>
            <p class="text-muted">Create your first deck and start adding cards!</p>
            <a href="{{ route('decks.create') }}" class="btn btn-primary px-4">
                <i class="bi bi-plus-circle me-1"></i>Create First Deck
            </a>
        </div>
    @else
        <div class="row g-3">
            @foreach($decks as $deck)
                <div class="col-sm-6 col-lg-4">
                    <div class="deck-card">
                        <div class="deck-color-bar bar-{{ $deck->color }}"></div>
                        <div class="deck-body">
                            <div class="deck-title">{{ $deck->title }}</div>
                            @if($deck->description)
                                <p class="text-muted small mt-1 mb-2">{{ Str::limit($deck->description, 80) }}</p>
                            @endif
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-layers me-1"></i>{{ $deck->cards_count }} cards
                                </span>
                                <span class="text-muted small">{{ $deck->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="deck-actions">
                                <a href="{{ route('decks.study', $deck) }}" class="btn btn-primary btn-sm flex-fill">
                                    <i class="bi bi-play-fill me-1"></i>Study
                                </a>
                                <a href="{{ route('decks.show', $deck) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('decks.edit', $deck) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('decks.destroy', $deck) }}" method="POST"
                                      onsubmit="return confirm('Delete this deck and all its cards?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $decks->links() }}
        </div>
    @endif
</div>
@endsection
