{{-- The cover carousel at the top of this category's screen in the app.
     Every level can carry one. Pictures can be staged with the switch off,
     or hidden without being lost. --}}
@php
    $category = $category ?? null;
    $covers = $category?->covers ?? collect();
@endphp

<hr>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Cover images</h5>

    <label class="d-flex align-items-center mb-0">
        <input type="hidden" name="show_cover" value="0">
        <input type="checkbox" name="show_cover" value="1" style="transform: scale(1.4)"
               {{ old('show_cover', $category?->show_cover) ? 'checked' : '' }}>
        <span class="mx-3">Show cover carousel in the app</span>
    </label>
</div>

<div class="row">
    <div class="mb-3 col-md-6">
        <label class="form-label">
            Add images
            <small class="text-info">(900&times;450 works best — keep every slide the same size; pick several at once for a slideshow)</small>
        </label>
        <input type="file" name="cover_images[]" class="form-control" accept="image/*" multiple>
    </div>
</div>

@if ($covers->isNotEmpty())
    <div class="row">
        @foreach ($covers as $cover)
            <div class="mb-3 col-md-3">
                <img src="{{ getImage($cover->thumbnail) }}" alt=""
                     class="img-fluid rounded border mb-1" style="width:100%; height:110px; object-fit:cover">

                <label class="d-flex align-items-center small mb-0">
                    <input type="checkbox" name="remove_covers[]" value="{{ $cover->id }}">
                    <span class="mx-2 text-danger">remove</span>
                </label>
            </div>
        @endforeach
    </div>
@endif
