{{-- Floating contact button and the sheet it opens. Belongs in the layout's
     "bottom" section; app.js wires it up by these ids. --}}
<button type="button" class="fab-contact" id="contact-open" aria-label="Contact {{ $entity->name }}">
    <span class="material-symbols-rounded">call</span>
</button>

<div class="sheet-scrim" id="contact-scrim"></div>

<div class="sheet sheet-contact" id="contact-sheet">
    <div class="sheet-handle"></div>

    <div class="sheet-scroll">
        @include('mobile.partials.contact-card', [
            'entity' => $entity,
            'ownerLabel' => $ownerLabel,
        ])
    </div>
</div>
