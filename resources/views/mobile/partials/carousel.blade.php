{{-- CustomSlider — 16:9, radius 10, dots below. $autoplay mirrors autoPlay. --}}
@php
    $slides = collect($banners ?? [])->pluck('thumbnail')->filter()->values();
    $autoplay = $autoplay ?? true;
@endphp

@if ($slides->isNotEmpty())
    <div class="carousel" data-autoplay="{{ $autoplay ? 'true' : 'false' }}">
        <div class="carousel-track">
            @foreach ($slides as $thumbnail)
                <div class="carousel-slide">
                    <img src="{{ asset('storage/' . $thumbnail) }}"
                         alt=""
                         loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                         data-fallback="{{ asset('mobile/img/placeholder.jpeg') }}">
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
