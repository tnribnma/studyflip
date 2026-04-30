@extends('layouts.app')
@section('title', 'Create Deck')

@section('content')
<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-plus-circle me-2"></i>Create New Deck</h1>
        <p>Give your deck a name and customize it</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Deck Details</div>
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('decks.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="title">Deck Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="e.g. PHP Basics, World History..."
                                   value="{{ old('title') }}" required maxlength="100">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="description">Description <span class="text-muted">(optional)</span></label>
                            <textarea id="description" name="description"
                                      class="form-control" rows="3"
                                      placeholder="What will you study in this deck?"
                                      maxlength="500">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Deck Color</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach(['blue' => '#3b82f6','green' => '#10b981','purple' => '#8b5cf6','orange' => '#f97316','red' => '#ef4444','teal' => '#14b8a6'] as $color => $hex)
                                    <label class="color-opt">
                                        <input type="radio" name="color" value="{{ $color }}"
                                               {{ old('color', 'blue') === $color ? 'checked' : '' }}
                                               style="display:none">
                                        <span style="
                                            display:inline-block; width:36px; height:36px;
                                            background:{{ $hex }}; border-radius:50%; cursor:pointer;
                                            border: 3px solid transparent;
                                            transition: border .2s;
                                        " class="color-swatch" data-color="{{ $color }}"></span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-check-circle me-1"></i>Create Deck
                            </button>
                            <a href="{{ route('decks.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
    document.querySelectorAll('input[name="color"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.color-swatch').forEach(s => s.style.border = '3px solid transparent');
            this.nextElementSibling.style.border = '3px solid #1e293b';
        });
        if (radio.checked) {
            radio.nextElementSibling.style.border = '3px solid #1e293b';
        }
    });
</script>
@endpush
