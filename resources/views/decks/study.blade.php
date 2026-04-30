@extends('layouts.app')
@section('title', 'Study: ' . $deck->title)

@push('styles')
<style>
    .study-wrapper {
        min-height: calc(100vh - 130px);
        background: linear-gradient(135deg, #f0f4ff, #f8fafc);
        padding: 2rem 0;
    }
    .study-header {
        text-align: center; margin-bottom: 2rem;
    }
    .study-header h2 { font-family: 'Syne', sans-serif; font-weight: 800; }

    .progress { height: 8px; border-radius: 99px; background: #e2e8f0; }
    .progress-bar { background: #4f46e5; border-radius: 99px; transition: width .4s ease; }

    .flip-scene {
        perspective: 1200px;
        width: 100%; max-width: 560px;
        height: 320px; margin: 0 auto;
        cursor: pointer;
    }
    .flip-card {
        width: 100%; height: 100%;
        position: relative; transform-style: preserve-3d;
        transition: transform .6s cubic-bezier(.4,0,.2,1);
    }
    .flip-card.flipped { transform: rotateY(180deg); }
    .flip-face {
        position: absolute; inset: 0;
        backface-visibility: hidden;
        border-radius: 20px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        padding: 2rem; text-align: center;
        box-shadow: 0 8px 40px rgba(79,70,229,.15);
    }
    .flip-face-front {
        background: #fff;
        border: 2px solid #e2e8f0;
    }
    .flip-face-back {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        transform: rotateY(180deg);
    }
    .flip-face-front h3 { font-family: 'Syne', sans-serif; font-size: 1.4rem; color: #1e293b; }
    .flip-face-back  h3 { font-family: 'Syne', sans-serif; font-size: 1.4rem; color: #fff; }
    .flip-hint { font-size: .82rem; color: #94a3b8; margin-top: .5rem; }
    .flip-label {
        position: absolute; top: 14px; left: 18px;
        font-size: .72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1px;
        opacity: .5;
    }

    .study-controls {
        display: flex; gap: 1rem; justify-content: center;
        flex-wrap: wrap; margin-top: 1.5rem;
    }
    .btn-flip {
        background: #4f46e5; color: #fff; border: none;
        border-radius: 12px; padding: .65rem 1.5rem;
        font-weight: 600; cursor: pointer; transition: all .2s;
    }
    .btn-flip:hover { background: #3730a3; transform: translateY(-1px); }
    .btn-nav {
        background: #fff; color: #4f46e5;
        border: 2px solid #4f46e5; border-radius: 12px;
        padding: .6rem 1.25rem; font-weight: 600;
        cursor: pointer; transition: all .2s;
    }
    .btn-nav:hover  { background: #4f46e5; color: #fff; }
    .btn-nav:disabled { opacity: .35; pointer-events: none; }

    .card-counter { text-align: center; color: #64748b; font-size: .9rem; margin-top: .75rem; }

    .finish-card {
        background: #fff; border-radius: 20px;
        text-align: center; padding: 3rem 2rem;
        box-shadow: 0 8px 40px rgba(79,70,229,.12);
        max-width: 480px; margin: 0 auto;
    }
    .finish-card h2 { font-family: 'Syne', sans-serif; font-weight: 800; }
</style>
@endpush

@section('content')
<div class="study-wrapper">
    <div class="container">

        <div class="study-header">
            <a href="{{ route('decks.show', $deck) }}" class="text-muted small mb-2 d-block">
                ← Back to {{ $deck->title }}
            </a>
            <h2>{{ $deck->title }}</h2>
            <p class="text-muted">Click the card to reveal the answer</p>
        </div>

        <div id="studyArea">

            <div style="max-width:560px; margin:0 auto 1rem">
                <div class="progress">
                    <div class="progress-bar" id="progressBar" style="width:0%"></div>
                </div>
            </div>

            <div class="flip-scene" id="flipScene">
                <div class="flip-card" id="flipCard">
                    <div class="flip-face flip-face-front">
                        <span class="flip-label">Question</span>
                        <h3 id="cardFront">Loading...</h3>
                        <p class="flip-hint" id="cardHint"></p>
                        <p class="text-muted small mt-3"> Click to flip</p>
                    </div>
                    <div class="flip-face flip-face-back">
                        <span class="flip-label" style="color:rgba(255,255,255,.5)">Answer</span>
                        <h3 id="cardBack">Loading...</h3>
                    </div>
                </div>
            </div>

            <div class="card-counter">
                Card <span id="currentNum">1</span> of <span id="totalNum">?</span>
            </div>

            <div class="study-controls">
                <button class="btn-nav" id="prevBtn" disabled>← Prev</button>
                <button class="btn-flip" id="flipBtn"> <img src="/images/icon-flip.svg" alt="Flip" style="width:18px;height:18px;margin-right:6px;vertical-align:middle;filter:brightness(0) invert(1);"> Flip</button>
                <button class="btn-nav" id="nextBtn">Next →</button>
            </div>

            <div class="text-center mt-3">
                <button class="btn btn-outline-secondary btn-sm" id="shuffleBtn">
                    <i class="bi bi-shuffle me-1"></i>Shuffle
                </button>
            </div>
        </div>

        <div id="finishArea" style="display:none">
            <div class="finish-card"><img src="/images/icon-celebrate.svg" alt="Celebrate" style="width:64px;height:64px;"></div>
                <div style="font-size:4rem"></div>
                <h2 class="mt-2">You finished!</h2>
                <p class="text-muted">You reviewed all <strong id="finishCount"></strong> cards in this deck.</p>
                <div class="d-flex gap-2 justify-content-center mt-3 flex-wrap">
                    <button class="btn btn-primary" onclick="restartStudy()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Study Again
                    </button>
                    <a href="{{ route('decks.show', $deck) }}" class="btn btn-outline-secondary">
                        Back to Deck
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const cards = @json($cards->values());
    let current = 0;

    function render() {
        const card = cards[current];
        document.getElementById('cardFront').textContent = card.front;
        document.getElementById('cardBack').textContent  = card.back;
        document.getElementById('cardHint').textContent  = card.hint ? + card.hint : '';
        document.getElementById('currentNum').textContent = current + 1;
        document.getElementById('totalNum').textContent   = cards.length;

        const pct = ((current) / cards.length) * 100;
        document.getElementById('progressBar').style.width = pct + '%';

        document.getElementById('flipCard').classList.remove('flipped');

        document.getElementById('prevBtn').disabled = current === 0;
        document.getElementById('nextBtn').textContent = current === cards.length - 1 ? 'Finish ✓' : 'Next →';
    }

    function flip() {
        document.getElementById('flipCard').classList.toggle('flipped');
    }

    function next() {
        if (current < cards.length - 1) {
            current++;
            render();
        } else {
            document.getElementById('studyArea').style.display = 'none';
            document.getElementById('finishArea').style.display = 'block';
            document.getElementById('finishCount').textContent = cards.length;
        }
    }

    function prev() {
        if (current > 0) { current--; render(); }
    }

    function restartStudy() {
        current = 0;
        document.getElementById('finishArea').style.display = 'none';
        document.getElementById('studyArea').style.display = 'block';
        render();
    }

    document.getElementById('shuffleBtn').addEventListener('click', function() {
        for (let i = cards.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [cards[i], cards[j]] = [cards[j], cards[i]];
        }
        current = 0;
        render();
    });

    document.getElementById('flipScene').addEventListener('click', flip);
    document.getElementById('flipBtn').addEventListener('click', flip);
    document.getElementById('nextBtn').addEventListener('click', next);
    document.getElementById('prevBtn').addEventListener('click', prev);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowRight') next();
        if (e.key === 'ArrowLeft')  prev();
        if (e.key === ' ') { e.preventDefault(); flip(); }
    });

    render();
</script>
@endpush
