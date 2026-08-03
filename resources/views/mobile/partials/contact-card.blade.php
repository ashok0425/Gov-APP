{{-- hello_ward.dart contact card. $ownerLabel differs for the Palika vs a ward. --}}
@php
    $whatsapp = trim((string) $entity->whatsapp);

    if ($whatsapp !== '') {
        // The app assumes a Nepal number when no country code is given.
        $whatsappDigits = preg_replace('/\D/', '', str_starts_with($whatsapp, '+') ? $whatsapp : '+977' . $whatsapp);
    }

    $mapLink = trim((string) $entity->google_map_link);
    $email = trim((string) $entity->email);
    $phone = trim((string) $entity->phone);
    $messenger = trim((string) $entity->messanger);
    $facebook = trim((string) $entity->facebook);
    $website = trim((string) $entity->other);
@endphp

<div class="contact-card">
    <div class="contact-head">
        <span class="contact-avatar">
            @if (filled($entity->thumbnail))
                <img src="{{ asset('storage/' . $entity->thumbnail) }}"
                     alt=""
                     loading="lazy"
                     data-fallback="{{ asset('mobile/img/placeholder-thumb.jpeg') }}">
            @endif
        </span>

        <span class="contact-name">{{ $entity->name }}</span>
    </div>

    <div class="contact-owner">
        <span>{{ $ownerLabel }} :&nbsp;</span>
        <span>{{ $entity->owner_name }}</span>
    </div>

    <a class="contact-address {{ $mapLink === '' ? 'is-disabled' : '' }}"
       href="{{ $mapLink !== '' ? $mapLink : '#' }}"
       target="_blank"
       rel="noopener">
        <span class="material-symbols-rounded">location_on</span>
        <span>{{ $entity->address }}</span>
    </a>

    <a class="contact-row {{ $email === '' ? 'is-disabled' : '' }}"
       href="{{ $email !== '' ? 'mailto:' . $email : '#' }}">
        <span>इमेल :</span>
        <span class="grow">{{ $email }}</span>
    </a>

    <a class="contact-row {{ $phone === '' ? 'is-disabled' : '' }}"
       href="{{ $phone !== '' ? 'tel:' . $phone : '#' }}">
        <span>फोन गर्नुहोस् :</span>
        <span class="grow">{{ $phone }}</span>
    </a>

    <div class="contact-row">
        <a class="half {{ $whatsapp === '' ? 'is-disabled' : '' }}"
           href="{{ $whatsapp !== '' ? 'https://wa.me/' . $whatsappDigits : '#' }}"
           target="_blank"
           rel="noopener">
            <img src="{{ asset('mobile/img/whatsapp.png') }}" alt="">
            <span class="label">WhatsApp<br>मा सन्देश पठाउँनुहोस</span>
        </a>

        <span class="split"></span>

        <a class="half {{ $phone === '' ? 'is-disabled' : '' }}"
           href="{{ $phone !== '' ? 'sms:' . $phone : '#' }}">
            <span class="material-symbols-rounded" style="color:var(--blue)">sms</span>
            <span class="label">SMS पठाउँनुहोस</span>
        </a>
    </div>

    <div class="contact-row">
        <a class="half {{ $messenger === '' ? 'is-disabled' : '' }}"
           href="{{ $messenger !== '' ? $messenger : '#' }}"
           target="_blank"
           rel="noopener">
            <img src="{{ asset('mobile/img/messenger.png') }}" alt="">
            <span class="label">Messenger<br>मा सन्देश पठाउँनुहोस</span>
        </a>

        <span class="split"></span>

        <a class="half {{ $facebook === '' ? 'is-disabled' : '' }}"
           href="{{ $facebook !== '' ? $facebook : '#' }}"
           target="_blank"
           rel="noopener">
            <span class="material-symbols-rounded" style="color:var(--blue)">facebook</span>
            <span class="label">Facebook<br>मा जोडिनुहोस</span>
        </a>
    </div>

    <a class="contact-row {{ $website === '' ? 'is-disabled' : '' }}"
       href="{{ $website !== '' ? $website : '#' }}"
       target="_blank"
       rel="noopener">
        <span class="grow" style="font-weight:700">{{ $website }}</span>
    </a>
</div>
