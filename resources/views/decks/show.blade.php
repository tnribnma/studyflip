@extends('layouts.app')
@section('title', $deck->title)

@push('styles')
<style>
    .card-item {
        background: #fff; border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 1.1rem 1.25rem;
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 1rem;
        transition: box-shadow .2s;
    }
    .card-item:hover { box-shadow: 0 4px 20px rgba(79,70,229,.1); }
    .card-front { font-weight: 600; color: #1e293b; }
    .card-back  { color: #64748b; font-size: .9rem; margin-top: .2rem; }
    .card-hint  { font-size: .78rem; color: #a0aec0; margin-top: .15rem; font-style: italic; }
    .card-num   { font-family: 'Syne', sans-serif; font-weight: 700; color: #cbd5e1;
                  font-size: .9rem; min-width: 28px; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <h1>{{ $deck->title }}</h1>
                @if($deck->description)
                    <p>{{ $deck->description }}</p>
                @endif
                <span class="badge bg-white text-dark">{{ $cards->count() }} cards</span>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('decks.study', $deck) }}" class="btn btn-warning fw-bold">
                    <i class="bi bi-play-fill me-1"></i>Study Now
                </a>
                <a href="{{ route('cards.create', $deck) }}" class="btn btn-light">
                    <i class="bi bi-plus me-1"></i>Add Card
                </a>
                <a href="{{ route('decks.edit', $deck) }}" class="btn btn-light">
                    <i class="bi bi-pencil me-1"></i>Edit Deck
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">All Cards</h5>
        <a href="{{ route('decks.index') }}" class="text-muted small">← Back to Decks</a>
    </div>

    @if($cards->isEmpty())
        <div class="text-center py-5 bg-white rounded-4 border"><div><img src="/images/icon-card.svg" alt="No cards" style="width:56px;height:56px;opacity:0.5;"></div>
            <div style="font-size:3.5rem"></div>
            <h6 class="fw-bold mt-2">No cards yet</h6>
            <p class="text-muted small">Start adding flashcards to this deck</p>
            <a href="{{ route('cards.create', $deck) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Add First Card
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-2">
            @foreach($cards as $i => $card)
                <div class="card-item">
                    <div class="card-num">#{{ $i + 1 }}</div>
                    <div class="flex-fill">
                        <div class="card-front">{{ $card->front }}</div>
                        <div class="card-back">→ {{ $card->back }}</div>
                        @if($card->hint)
                            <div class="card-hint"> {{ $card->hint }}</div>
                        @endif
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ route('cards.edit', [$deck, $card]) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('cards.destroy', [$deck, $card]) }}" method="POST"
                              onsubmit="return confirm('Delete this card?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('cards.create', $deck) }}" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle me-1"></i>Add Another Card
            </a>
        </div>
    @endif
</div>
@endsection
