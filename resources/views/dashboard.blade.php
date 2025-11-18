@extends('adminlte::page')

@section('title', 'Dashboard | CargoTrack')

@section('content_header')
    <h1>CargoTrack Dashboard</h1>
    <meta name="user-name" content="{{ Auth::user() && Auth::user()->name ? Auth::user()->name : (Auth::user() && Auth::user()->email ? Auth::user()->email : '') }}">
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- ON TRAIN Card -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\Container::where('status', 'ON_TRAIN')->count() }}</h3>
                    <p>ON TRAIN</p>
                </div>
                <div class="icon">
                    <i class="fas fa-train"></i>
                </div>
                <a href="{{ route('containers.index', ['status' => 'ON_TRAIN']) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- DISCH Card -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\Container::where('status', 'DISCH')->count() }}</h3>
                    <p>DISCH</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('containers.index', ['status' => 'DISCH']) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- EMPTY IN CY Card -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\Container::where('status', 'EMPTY_IN_CY')->count() }}</h3>
                    <p>EMPTY IN CY</p>
                </div>
                <div class="icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <a href="{{ route('depots.empty-in-cy') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- FULL IN CY Card -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ \App\Models\Container::where('status', 'FULL_IN_CY')->count() }}</h3>
                    <p>FULL IN CY</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cube"></i>
                </div>
                <a href="{{ route('depots.full-in-cy') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Chart Card for Container Status Distribution -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Container Status Distribution</h3>
        </div>
        <div class="card-body">
            <canvas id="containerStatusChart" height="100"></canvas>
        </div>
    </div>
</div>
@stop

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js implementation for status distribution
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('containerStatusChart').getContext('2d');

        // Get status counts from the backend
        const statusData = [
            {{ \App\Models\Container::where('status', 'ON_TRAIN')->count() }},
            {{ \App\Models\Container::where('status', 'DISCH')->count() }},
            {{ \App\Models\Container::where('status', 'EMPTY_IN_CY')->count() }},
            {{ \App\Models\Container::where('status', 'FULL_IN_CY')->count() }},
            {{ \App\Models\Container::where('status', 'FULL_OUT_CY')->count() }},
            {{ \App\Models\Container::where('status', 'EMPTY_OUT_CY')->count() }},
            {{ \App\Models\Container::where('status', 'LOAD')->count() }}
        ];

        const statusLabels = ['ON_TRAIN', 'DISCH', 'EMPTY_IN_CY', 'FULL_IN_CY', 'FULL_OUT_CY', 'EMPTY_OUT_CY', 'LOAD'];

        const statusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: [
                        '#007bff', '#28a745', '#ffc107', '#17a2b8', '#dc3545', '#6c757d', '#6610f2'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Replace the brand in the navbar with dynamic user info after a short delay to ensure DOM is fully loaded
        setTimeout(function() {
            const brandElement = document.querySelector('.brand-link');
            if (brandElement) {
                const userNameMeta = document.querySelector('meta[name="user-name"]');
                if (userNameMeta && userNameMeta.content) {
                    const displayName = userNameMeta.content.trim();

                    // Generate initials from name
                    let initials = '';
                    const nameParts = displayName.split(/\s+/);
                    for(let i = 0; i < Math.min(nameParts.length, 2) && i < 2; i++) {
                        const part = nameParts[i];
                        if(part && part.length > 0) {
                            initials += part[0].toUpperCase();
                        }
                    }

                    // Generate a color based on the name
                    let hash = 0;
                    for (let i = 0; i < displayName.length; i++) {
                        hash = displayName.charCodeAt(i) + ((hash << 5) - hash);
                    }
                    const hue = hash % 360;
                    const bgColor = `hsl(${hue}, 70%, 45%)`;

                    brandElement.innerHTML = `
                        <span class="brand-avatar" style="display: inline-block; width: 33px; height: 33px; border-radius: 50%; background-color: ${bgColor}; text-align: center; line-height: 33px; color: white; font-size: 14px; margin-right: 8px;">
                            ${initials || 'U'}
                        </span>
                        <span class="brand-text font-weight-light">${displayName}</span>
                    `;
                } else {
                    // Use default CargoTrack brand if no user is logged in
                    brandElement.innerHTML = `
                        <img src="vendor/adminlte/dist/img/AdminLTELogo.png"
                             alt="Admin Logo"
                             class="brand-image img-circle elevation-3"
                             style="opacity:.8">
                        <span class="brand-text font-weight-light">
                            <b>Cargo</b>Track
                        </span>
                    `;
                }
            }
        }, 100); // 100ms delay to ensure page is loaded

        // Adjust brand display when sidebar collapses/expands
        function updateBrandStyle() {
            const sidebar = document.querySelector('body');
            const brandLink = document.querySelector('.brand-link');

            if (brandLink) {
                // When sidebar is collapsed (mini), show only the avatar
                if (sidebar.classList.contains('sidebar-mini') && sidebar.classList.contains('sidebar-collapse')) {
                    // Hide the text part and only show the avatar
                    const avatarElement = brandLink.querySelector('.brand-avatar');
                    const textElement = brandLink.querySelector('.brand-text');

                    if (avatarElement) {
                        avatarElement.style.display = 'flex';
                        avatarElement.style.alignItems = 'center';
                        avatarElement.style.justifyContent = 'center';
                        avatarElement.style.margin = '0 auto';
                    }

                    if (textElement) {
                        textElement.style.display = 'none';
                    }
                } else {
                    // When sidebar is expanded, show both avatar and text
                    const avatarElement = brandLink.querySelector('.brand-avatar');
                    const textElement = brandLink.querySelector('.brand-text');

                    if (avatarElement) {
                        avatarElement.style.display = 'inline-block';
                        avatarElement.style.alignItems = '';
                        avatarElement.style.justifyContent = '';
                        avatarElement.style.marginRight = '8px';
                    }

                    if (textElement) {
                        textElement.style.display = 'inline';
                    }
                }
            }
        }

        // Initialize brand style
        updateBrandStyle();

        // Watch for sidebar collapse/expand events
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    updateBrandStyle();
                }
            });
        });

        // Start observing changes to body classes
        const body = document.querySelector('body');
        if (body) {
            observer.observe(body, {
                attributes: true,
                attributeFilter: ['class']
            });
        }

        // Also listen for AdminLTE sidebar events
        document.addEventListener('collapsed.lte.pushmenu', updateBrandStyle);
        document.addEventListener('shown.lte.pushmenu', updateBrandStyle);
    });
</script>
@endpush
