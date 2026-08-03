{{-- Navigator.pop equivalent: step back when there is a stack, else fall home. --}}
<a class="icon-btn"
   href="{{ $fallback ?? route('m.home') }}"
   aria-label="Back"
   onclick="if (history.length > 1) { history.back(); return false; }">
    <span class="material-symbols-rounded">arrow_back</span>
</a>
