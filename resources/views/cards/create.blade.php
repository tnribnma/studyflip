@extends('layouts.app')
@section('title', 'Add Card')

@section('content')
<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-plus-square me-2"></i>Add Card</h1>
        <p>Adding to: <strong>{{ $deck->title }}</strong></p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><img src="/images/icon-card.svg" alt="" style="width:20px;height:20px;margin-right:6px;vertical-align:middle;">New Flashcard</div>
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cards.store', $deck) }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="front">
                                Front (Question / Term) <span class="text-danger">*</span>
                            </label>
                            <textarea id="front" name="front"
                                      class="form-control @error('front') is-invalid @enderror"
                                      rows="3" placeholder="Write the question or term here..."
                                      required maxlength="500">{{ old('front') }}</textarea>
                            @error('front')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text text-end"><span id="frontCount">0</span>/500</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="back">
                                Back (Answer / Definition) <span class="text-danger">*</span>
                            </label>
                            <textarea id="back" name="back"
                                      class="form-control @error('back') is-invalid @enderror"
                                      rows="3" placeholder="Write the answer or definition here..."
                                      required maxlength="500">{{ old('back') }}</textarea>
                            @error('back')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text text-end"><span id="backCount">0</span>/500</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="hint">
                                Hint <span class="text-muted">(optional)</span>
                            </label>
                            <input type="text" id="hint" name="hint"
                                   class="form-control" placeholder="A small hint to help remember..."
                                   value="{{ old('hint') }}" maxlength="200">
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <button type="submit" name="save" class="btn btn-primary flex-fill">
                                <i class="bi bi-check-circle me-1"></i>Save Card
                            </button>
                            <button type="submit" name="add_another" value="1" class="btn btn-outline-primary">
                                <i class="bi bi-plus-circle me-1"></i>Save & Add Another
                            </button>
                            <a href="{{ route('decks.show', $deck) }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function countChars(inputId, countId) {
        const el = document.getElementById(inputId);
        const counter = document.getElementById(countId);
        el.addEventListener('input', () => counter.textContent = el.value.length);
        counter.textContent = el.value.length;
    }
    countChars('front', 'frontCount');
    countChars('back', 'backCount');
</script>
@endpush
