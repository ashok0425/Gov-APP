{{-- A notification in the सूचना list: picture if it has one, title, the one
     line the admin wrote, and the date it went out. A notice that points at
     an outside page opens that; the rest open their own screen. --}}
@foreach ($notices as $notice)
    <a class="blog-row"
       href="{{ $notice->link ?: route('m.notice', $notice->id) }}"
       @if ($notice->link) target="_blank" rel="noopener" @endif>
        @if (filled($notice->thumbnail))
            <img src="{{ asset('storage/' . $notice->thumbnail) }}"
                 alt=""
                 loading="lazy"
                 data-fallback-icon="campaign"
                 data-fallback-wrap="notice-mark">
        @else
            <span class="notice-mark">
                <span class="material-symbols-rounded">campaign</span>
            </span>
        @endif

        <span class="blog-row-body">
            <span class="blog-row-title">{{ $notice->title }}</span>

            @if (filled($notice->short_description))
                <span class="blog-row-desc">{{ $notice->short_description }}</span>
            @endif

            <span class="blog-row-meta">{{ $notice->sent_at?->format('Y-m-d H:i') }}</span>
        </span>
    </a>
@endforeach
