{{-- सूचना: the one-line ticker under the banner, fed by the posts the
     admin ticks as breaking. The track holds the same run twice and slides by
     exactly half its width, so the loop has no seam. It is CSS, not a
     <marquee> tag: that element is deprecated and cannot be paused. --}}
@php
    $items = collect($posts ?? [])->take(8)->values();
    // Long lists need longer to pass by, or short ones race.
    $seconds = max(14, $items->count() * 7);
@endphp

@if ($items->isNotEmpty())
    <div class="news-ticker">
        <span class="ticker-label">
            <span class="material-symbols-rounded">campaign</span>
            सूचना
        </span>

        <div class="ticker-window">
            <div class="ticker-track" style="--ticker-duration: {{ $seconds }}s">
                @foreach ([1, 2] as $pass)
                    {{-- The second run only fills the seam; screen readers read one. --}}
                    <div class="ticker-run" @if ($pass === 2) aria-hidden="true" @endif>
                        @foreach ($items as $post)
                            <a href="{{ route('m.blog', $post->id) }}" class="ticker-item">{{ $post->title }}</a>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
