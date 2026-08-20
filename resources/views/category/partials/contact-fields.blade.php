{{-- The contact card the app floats behind the green phone button on this
     category's screen. Only levels below the top carry one — a main category
     is a heading, not an office a citizen can ring. --}}
@php
    $category = $category ?? null;
@endphp

<hr>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Contact</h5>

    <label class="d-flex align-items-center mb-0">
        <input type="hidden" name="show_contact" value="0">
        <input type="checkbox" name="show_contact" value="1" style="transform: scale(1.4)"
               {{ old('show_contact', $category?->show_contact) ? 'checked' : '' }}>
        <span class="mx-3">Show contact button in the app</span>
    </label>
</div>

<div class="row">
    <div class="mb-3 col-md-4">
        <label class="form-label">Contact Person</label>
        <input type="text" name="owner_name" class="form-control" placeholder="name of the person or office"
               value="{{ old('owner_name', $category?->owner_name) }}">
    </div>

    <div class="mb-3 col-md-4">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" placeholder="9800000000"
               value="{{ old('phone', $category?->phone) }}">
    </div>

    <div class="mb-3 col-md-4">
        <label class="form-label">WhatsApp</label>
        <input type="text" name="whatsapp" class="form-control" placeholder="9800000000"
               value="{{ old('whatsapp', $category?->whatsapp) }}">
    </div>

    <div class="mb-3 col-md-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="office@example.gov.np"
               value="{{ old('email', $category?->email) }}">
    </div>

    <div class="mb-3 col-md-8">
        <label class="form-label">Address</label>
        <input type="text" name="address" class="form-control" placeholder="office address"
               value="{{ old('address', $category?->address) }}">
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label">Google Map Link</label>
        <input type="url" name="google_map_link" class="form-control" placeholder="https://maps.google.com/..."
               value="{{ old('google_map_link', $category?->google_map_link) }}">
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label">Facebook</label>
        <input type="url" name="facebook" class="form-control" placeholder="https://facebook.com/..."
               value="{{ old('facebook', $category?->facebook) }}">
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label">Messenger</label>
        <input type="url" name="messanger" class="form-control" placeholder="https://m.me/..."
               value="{{ old('messanger', $category?->messanger) }}">
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label">Other <small class="text-info">(anything else worth showing)</small></label>
        <input type="text" name="other" class="form-control"
               value="{{ old('other', $category?->other) }}">
    </div>
</div>
