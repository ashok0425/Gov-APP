{{-- CustomSlider — 1080x400 slides, rounded corners, dots below. Always auto-plays. --}}
@php
    $slides = collect($banners ?? [])->pluck('thumbnail')->filter()->values();
@endphp

@if ($slides->isNotEmpty())
    <div class="carousel">
        <div class="carousel-track">
            @foreach ($slides as $thumbnail)
                <div class="carousel-slide">
                    <img src="{{ asset('storage/' . $thumbnail) }}"
                         alt=""
                         loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                         data-fallback-hide>
                </div>
            @endforeach
        </div>

        @if ($slides->count() > 1)
            <div class="carousel-dots">
                @foreach ($slides as $i => $thumbnail)
                    <button type="button"
                            class="carousel-dot {{ $i === 0 ? 'is-active' : '' }}"
                            aria-label="Slide {{ $i + 1 }}"></button>
                @endforeach
            </div>
        @endif
    </div>
@endif
