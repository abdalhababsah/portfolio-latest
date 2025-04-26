{{-- resources/views/components/admin/kpi.blade.php --}}
@props([
    'value',          // main figure  – e.g. 1 234
    'label',          // small upper-case label – e.g. “Total Views”
    'icon'    => 'ti ti-circle',  // Tabler-icon or any icon class
    'colour'  => 'primary',       // bootstrap contextual colour
    'trend'   => null,            // optional percentage (+/-) for the footnote
    'since'   => 'Since last month' // footnote text
])

<div {{ $attributes->merge(['class' => 'col']) }}>
    <div class="card">
        <div class="card-body">

            {{-- label --}}
            <h5 class="text-muted fs-13 text-uppercase" title="{{ $label }}">{{ $label }}</h5>

            {{-- icon + value line --}}
            <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                <div class="user-img fs-42 flex-shrink-0">
                    <span class="avatar-title text-bg-{{ $colour }} rounded-circle fs-22">
                        {{-- If you prefer Iconify --}}
                        {{-- <iconify-icon icon="{{ $icon }}"></iconify-icon> --}}
                        <i class="{{ $icon }}"></i>
                    </span>
                </div>
                <h3 class="mb-0 fw-bold">{{ $value }}</h3>
            </div>

            {{-- footnote (optional) --}}
            @isset($trend)
                <p class="mb-0 text-muted">
                    <span class="{{ $trend >= 0 ? 'text-success' : 'text-danger' }} me-2">
                        <i class="ti {{ $trend >= 0 ? 'ti-caret-up-filled' : 'ti-caret-down-filled' }}"></i>
                        {{ abs($trend) }}%
                    </span>
                    <span class="text-nowrap">{{ $since }}</span>
                </p>
            @endisset

        </div><!-- /.card-body -->
    </div><!-- /.card -->
</div>