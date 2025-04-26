@extends('admin.layout.app')

@section('content')
<div class="page-container ">

    {{-- ───── Heading ───────────────────────────────────────── --}}
    <div class="row mb-4 ">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h4 class="fs-18 text-uppercase fw-bold mb-0">Dashboard</h4>
            <span class="text-muted small">updated {{ now()->format('d M Y H:i') }}</span>
        </div>
    </div>

    {{-- ───── KPI cards ─────────────────────────────────────── --}}
    <div class="row row-cols-xl-6 row-cols-sm-3 g-3 text-center">

        {{-- total page views --}}
        <x-admin.kpi  colour="primary"
                      :value="$totalViews"
                      label="Total Views"
                      icon="ti ti-eye" />

        {{-- todays views --}}
        <x-admin.kpi  colour="info"
                      :value="$todayViews"
                      label="Views Today"
                      icon="ti ti-bolt" />

        {{-- unique visitors --}}
        <x-admin.kpi  colour="success"
                      :value="$uniqueVisitors"
                      label="Unique Visitors"
                      icon="ti ti-users" />

        {{-- content counters --}}
        <x-admin.kpi  colour="secondary"
                      :value="$projectsCount"
                      label="Projects"
                      icon="ti ti-briefcase" />

        <x-admin.kpi  colour="secondary"
                      :value="$servicesCount"
                      label="Services"
                      icon="ti ti-handshake" />

        {{-- inbox --}}
        <x-admin.kpi  colour="danger"
                      :value="$unreadContacts"
                      label="Unread Contacts"
                      icon="ti ti-mail" />
    </div>

    {{-- ───── Charts & tables ───────────────────────────────── --}}
    <div class="row mt-4">

        {{-- 30-day views chart --}}
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Page Views – last 30 days</h5>
                </div>
                <div class="card-body">
                    <div id="views-chart" style="height:280px;"></div>
                </div>
            </div>
        </div>

        {{-- Top routes --}}
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Top Routes</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-borderless mb-0">
                        <thead class="table-light">
                            <tr><th>Route</th><th class="text-end">Hits</th></tr>
                        </thead>
                        <tbody>
                            @foreach($topRoutes as $r)
                                <tr>
                                    <td><i class="ti ti-link text-muted me-1"></i>{{ $r->route_name ?: '—' }}</td>
                                    <td class="text-end fw-semibold">{{ $r->hits }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- /row -->

    {{-- ───── secondary counters (optional) ─────────────────── --}}
    <div class="row row-cols-lg-4 row-cols-sm-2 g-3 mt-4">

        <x-admin.kpi  :value="$skillsCount"
                      label="Skills"
                      colour="warning"
                      icon="ti ti-tools" />

        <x-admin.kpi  :value="$certificatesCount"
                      label="Certificates"
                      colour="warning"
                      icon="ti ti-certificate" />

    </div>

</div> <!-- /page-container -->
@endsection


@push('scripts')
{{-- Apex-Charts for the 30-day view --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    (function () {
        const options = {
            chart:   { type: 'area', height: 280, toolbar: { show: false } },
            series:  [{ name: 'Page views', data: @json($counts) }],
            xaxis:   { categories: @json($dates), labels:{ show:false } },
            stroke:  { curve: 'smooth' },
            colors:  ['#4dabf7'],
            tooltip: { x: { format: 'dd MMM' } }
        };
        new ApexCharts(document.querySelector('#views-chart'), options).render();
    })();
</script>
@endpush