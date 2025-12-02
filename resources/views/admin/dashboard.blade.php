@extends('layouts.admin')

@section('title', 'Dashboard | Printex Admin')

@section('content')
    <div class="mb-4">
        <h1 class="fw-bold mb-1">Dashboard</h1>
        <p class="text-muted mb-0">Resumen general de ventas, cursos y usuarios.</p>
    </div>

    <div class="row g-4 mb-4">
        @foreach ([
            ['label' => 'Total ventas', 'value' => 'S/ ' . number_format($metrics['sales'] ?? 0, 2), 'icon' => 'bi-currency-dollar', 'text' => '+12% mensual'],
            ['label' => 'Pedidos pendientes', 'value' => $metrics['pending_orders'] ?? 0, 'icon' => 'bi-bag', 'text' => 'Necesitan revisión'],
            ['label' => 'Cursos activos', 'value' => $metrics['active_courses'] ?? 0, 'icon' => 'bi-journal-richtext', 'text' => 'Más populares visibles'],
            ['label' => 'Nuevos usuarios', 'value' => $metrics['new_users'] ?? 0, 'icon' => 'bi-people', 'text' => 'Últimos 30 días'],
        ] as $card)
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-uppercase small">{{ $card['label'] }}</span>
                            <i class="bi {{ $card['icon'] }} text-primary fs-4"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $card['value'] }}</h3>
                        <p class="text-muted small mb-0">{{ $card['text'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">Ventas mensuales</h5>
                            <p class="text-muted small mb-0">Comparativa de los últimos 12 meses.</p>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="window.print()">Exportar</button>
                    </div>
                    <div style="height: 320px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Cursos más populares</h5>
                    <ul class="list-group list-group-flush">
                        @forelse ($popularCourses ?? [] as $course)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $course->name }}</span>
                                <span class="badge text-bg-primary">{{ $course->enrollments_count }} inscripciones</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Aún no hay datos disponibles.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Estados de pedidos</h5>
                    <div style="height: 260px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const salesCtx = document.getElementById('salesChart');
            const statusCtx = document.getElementById('statusChart');

            const salesSeries = @json($salesSeries ?? []);
            const statusSeries = @json($statusSeries ?? []);

            if (salesCtx && salesSeries.length) {
                const labels = salesSeries.map(item => item.label);
                const data = salesSeries.map(item => item.total);

                new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Ventas (S/)',
                            data,
                            borderColor: '#1e40af',
                            backgroundColor: 'rgba(30, 64, 175, 0.12)',
                            tension: 0.35,
                            fill: true,
                            pointRadius: 4,
                            pointBackgroundColor: '#1e40af',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { callback: value => 'S/ ' + value }
                            }
                        }
                    }
                });
            }

            if (statusCtx && statusSeries.length) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusSeries.map(item => item.status),
                        datasets: [{
                            data: statusSeries.map(item => item.total),
                            backgroundColor: ['#1e40af', '#f59e0b', '#10b981', '#ef4444', '#6b7280'],
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });
            }
        });
    </script>
@endpush
