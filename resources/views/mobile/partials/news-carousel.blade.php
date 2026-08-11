{{-- Breaking news slider. Same markup/behaviour as the banner carousel, but
     each slide links to its post and carries the headline over the image. --}}
@if ($posts->isNotEmpty())
    <div class="carousel carousel-news" data-autoplay="true">
        <div class="carousel-track">
            @foreach ($posts as $post)
                <a class="carousel-slide" href="{{ route('m.blog', $post->id) }}">
                    <img src="{{ filled($post->thumbnail) ? asset('storage/' . $post->thumbnail) : asset('mobile/img/placeholder.jpeg') }}"
                         alt=""
                         loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                         data-fallback="{{ asset('mobile/img/placeholder.jpeg') }}">

                    <span class="carousel-caption">{{ $post->title }}</span>
                </a>
            @endforeach
        </div>

        @if ($posts->count() > 1)
            <div class="carousel-dots">
                @foreach ($posts as $i => $post)
                    <button type="button"
                            class="carousel-dot {{ $i === 0 ? 'is-active' : '' }}"
                            aria-label="Slide {{ $i + 1 }}"></button>
                @endforeach
            </div>
        @endif
    </div>
@endif
