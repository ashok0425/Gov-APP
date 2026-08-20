{{-- The one paginated list, everywhere a screen shows posts: the first page
     is server-rendered, and initInfiniteList in app.js fetches page 2+ from
     $url as JSON — home, category and search all differ only in the URL,
     which carries their own parameters (category id, q, …). --}}
<div class="blog-list"
     id="infinite-list"
     data-url="{{ $url }}"
     data-page="{{ $blogs->currentPage() }}"
     data-has-more="{{ $blogs->hasMorePages() ? 'true' : 'false' }}">
    @include('mobile.partials.blog-rows', ['blogs' => $blogs])
</div>

@if ($blogs->hasMorePages())
    <div id="infinite-sentinel"><div class="spinner"></div></div>
@endif
