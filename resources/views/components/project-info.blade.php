@props([
    'label',            // e.g.  "Category:"
    'value' => null,    // optional – if omitted we'll display the slot instead
])

<div class="col-md-6 col-sm-6 col-lg-3">
    <div class="port-detail-info-box d-flex flex-column w-100">
        <strong>{{ $label }}</strong>
        <h4 class="mb-0 fw-normal sz-24">
            {{ $value ?? $slot }}
        </h4>
    </div>
</div>