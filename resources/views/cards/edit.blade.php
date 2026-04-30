@extends('layouts.app')
@section('title', 'Edit Card')

@section('content')
<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-pencil-square me-2"></i>Edit Card</h1>
        <p>Deck: <strong>{{ $deck->title }}</strong></p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Edit Flashcard</div>
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cards.update', [$deck, $card]) }}" method="POST" novalidate>
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Front (Question) <span class="text-danger">*</span></label>
                            <textarea name="front"
                                      class="form-control @error('front') is-invalid @enderror"
                                      rows="3" required maxlength="500">{{ old('front', $card->front) }}</textarea>
                            @error('front')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Back (Answer) <span class="text-danger">*</span></label>
                            <textarea name="back"
                                      class="form-control @error('back') is-invalid @enderror"
                                      rows="3" required maxlength="500">{{ old('back', $card->back) }}</textarea>
                            @error('back')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Hint <span class="text-muted">(optional)</span></label>
                            <input type="text" name="hint" class="form-control"
                                   value="{{ old('hint', $card->hint) }}" maxlength="200">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-check-circle me-1"></i>Save Changes
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
