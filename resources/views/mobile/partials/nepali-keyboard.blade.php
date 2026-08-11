@php
    // Devanagari laid out the way a Nepali reader expects it: vowels, then the
    // consonant varga rows, then the matras that hang off them. Matras are
    // drawn against a dotted circle (U+25CC) because a lone ा is invisible.
    $rows = [
        ['अ', 'आ', 'इ', 'ई', 'उ', 'ऊ', 'ए', 'ऐ', 'ओ', 'औ'],
        ['क', 'ख', 'ग', 'घ', 'ङ', 'च', 'छ', 'ज', 'झ', 'ञ'],
        ['ट', 'ठ', 'ड', 'ढ', 'ण', 'त', 'थ', 'द', 'ध', 'न'],
        ['प', 'फ', 'ब', 'भ', 'म', 'य', 'र', 'ल', 'व', 'श'],
        ['ष', 'स', 'ह', 'क्ष', 'त्र', 'ज्ञ', 'श्र', 'ऋ', 'ड़', 'ढ़'],
        ['ा', 'ि', 'ी', 'ु', 'ू', 'ृ', 'े', 'ै', 'ो', 'ौ'],
        ['ं', 'ँ', 'ः', '्'],
        ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'],
    ];

    // Rows whose characters are combining marks, so they need the dotted circle.
    $matraRows = [5, 6];
@endphp

<div class="nep-kb" id="nep-kb" role="group" aria-label="नेपाली किबोर्ड" hidden>
    <div class="nep-kb-keys">
        @foreach ($rows as $r => $keys)
            <div class="nep-kb-row">
                @foreach ($keys as $key)
                    <button type="button" class="nep-key" data-key="{{ $key }}" aria-label="{{ $key }}">
                        {{ in_array($r, $matraRows, true) ? '◌'.$key : $key }}
                    </button>
                @endforeach
            </div>
        @endforeach
    </div>

    <div class="nep-kb-row nep-kb-actions">
        <button type="button" class="nep-key nep-key-space" data-key=" ">स्पेस</button>
        <button type="button" class="nep-key nep-key-wide" data-action="backspace" aria-label="मेट्नुहोस्">
            <span class="material-symbols-rounded">backspace</span>
        </button>
        <button type="button" class="nep-key nep-key-go" data-action="search">खोज्नुहोस्</button>
    </div>
</div>
