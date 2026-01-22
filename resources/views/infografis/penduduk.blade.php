@extends('layouts.app')

@section('title', 'Statistik Penduduk')

@php
    use App\Models\Content;
    $namaDesa = Content::getContent('settings', 'general', 'namaDesa', 'Desa');
@endphp

@section('content')
<!-- Header -->
<div class="bg-[#1e3a8a] text-white py-8">
    <div class="container mx-auto px-4">
        <nav class="text-sm mb-2 text-blue-200">
            <a href="{{ route('beranda') }}" class="hover:text-white">Beranda</a>
            <span class="mx-2">›</span>
            <a href="{{ route('data') }}" class="hover:text-white">Infografis</a>
            <span class="mx-2">›</span>
            <span class="text-white">Penduduk</span>
        </nav>
        <h1 class="text-2xl md:text-3xl font-bold">Statistik Penduduk</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    
    <!-- Jumlah Penduduk -->
    <div class="bg-white border rounded-lg p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Jumlah Penduduk</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded">
                <div class="text-3xl font-bold text-blue-800">{{ number_format($statistik['total_penduduk']) }}</div>
                <div class="text-sm text-gray-600 mt-1">Total Penduduk</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded">
                <div class="text-3xl font-bold text-green-800">{{ number_format($statistik['total_kk']) }}</div>
                <div class="text-sm text-gray-600 mt-1">Kepala Keluarga</div>
            </div>
            <div class="text-center p-4 bg-indigo-50 rounded">
                <div class="text-3xl font-bold text-indigo-800">{{ number_format($statistik['total_laki_laki']) }}</div>
                <div class="text-sm text-gray-600 mt-1">Laki-laki</div>
            </div>
            <div class="text-center p-4 bg-pink-50 rounded">
                <div class="text-3xl font-bold text-pink-800">{{ number_format($statistik['total_perempuan']) }}</div>
                <div class="text-sm text-gray-600 mt-1">Perempuan</div>
            </div>
        </div>
    </div>

    <!-- Grafik Pendidikan (Bar Chart) -->
    @if($statistik['pendidikan']->count() > 0)
    <div class="bg-white border rounded-lg p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Berdasarkan Pendidikan</h2>
        <div class="h-80">
            <canvas id="chartPendidikan"></canvas>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Grafik Dusun (Pie Chart) -->
        @if($statistik['dusun']->count() > 0)
        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Berdasarkan Dusun</h2>
            <div class="h-72">
                <canvas id="chartDusun"></canvas>
            </div>
        </div>
        @endif

        <!-- Grafik Agama (Pie Chart) -->
        @if($statistik['agama']->count() > 0)
        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Berdasarkan Agama</h2>
            <div class="h-72">
                <canvas id="chartAgama"></canvas>
            </div>
        </div>
        @endif
    </div>

    <!-- Grafik Pekerjaan (Bar Chart) -->
    @if($statistik['pekerjaan']->count() > 0)
    <div class="bg-white border rounded-lg p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Berdasarkan Pekerjaan</h2>
        <div class="h-80">
            <canvas id="chartPekerjaan"></canvas>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Kelompok Umur -->
        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Berdasarkan Kelompok Umur</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left py-2 px-3 font-semibold text-gray-700">Umur</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-700">L</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-700">P</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-700">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistik['kelompok_umur'] as $umur)
                            @if($umur['total'] > 0)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-3 text-gray-700">{{ $umur['kelompok'] }} th</td>
                                <td class="py-2 px-3 text-center text-gray-800">{{ $umur['laki_laki'] }}</td>
                                <td class="py-2 px-3 text-center text-gray-800">{{ $umur['perempuan'] }}</td>
                                <td class="py-2 px-3 text-center font-semibold text-gray-900">{{ $umur['total'] }}</td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">Data belum tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Wajib Pilih -->
        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Pemilih (Usia 17+)</h2>
            <div class="flex items-center justify-center py-6">
                <div class="text-center">
                    <div class="text-5xl font-bold text-[#1e3a8a]">{{ number_format($statistik['wajib_pilih']['total']) }}</div>
                    <div class="text-gray-600 mt-2">Jiwa</div>
                    <div class="flex justify-center gap-8 mt-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($statistik['wajib_pilih']['laki_laki']) }}</div>
                            <div class="text-sm text-gray-500">Laki-laki</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($statistik['wajib_pilih']['perempuan']) }}</div>
                            <div class="text-sm text-gray-500">Perempuan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Grafik Perkawinan (Pie Chart) -->
        @if($statistik['perkawinan']->count() > 0)
        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Berdasarkan Status Perkawinan</h2>
            <div class="h-72">
                <canvas id="chartPerkawinan"></canvas>
            </div>
        </div>
        @endif

        <!-- Grafik Kelompok Umur (Bar Chart) -->
        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Grafik Kelompok Umur</h2>
            <div class="h-72">
                <canvas id="chartUmur"></canvas>
            </div>
        </div>
    </div>

    <!-- Info Update -->
    <div class="text-center text-sm text-gray-500 py-4">
        Data diperbarui secara berkala berdasarkan input dari administrasi desa.
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.register(ChartDataLabels);
    
    // Warna untuk chart
    const colors = [
        '#4472c4', '#8faadc', '#a9d18e', '#ffc000', '#ed7d31', 
        '#70ad47', '#5b9bd5', '#c5e0b4', '#ffe699', '#f4b183'
    ];

    // Chart Pendidikan (Bar)
    @if($statistik['pendidikan']->count() > 0)
    new Chart(document.getElementById('chartPendidikan'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($statistik['pendidikan']->pluck('pendidikan')->toArray()) !!},
            datasets: [{
                data: {!! json_encode($statistik['pendidikan']->pluck('total')->toArray()) !!},
                backgroundColor: '#5a8f3e',
                borderRadius: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#333',
                    font: { weight: 'bold', size: 11 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#e5e5e5' }
                },
                x: {
                    grid: { display: false },
                    ticks: { 
                        maxRotation: 45,
                        minRotation: 45,
                        font: { size: 10 }
                    }
                }
            }
        }
    });
    @endif

    // Chart Dusun (Pie)
    @if($statistik['dusun']->count() > 0)
    const dusunData = {!! json_encode($statistik['dusun']->map(function($d) { return ['label' => $d->dusun ?: 'Lainnya', 'value' => $d->total]; })->toArray()) !!};
    const dusunTotal = dusunData.reduce((a, b) => a + b.value, 0);
    
    new Chart(document.getElementById('chartDusun'), {
        type: 'pie',
        data: {
            labels: dusunData.map(d => d.label),
            datasets: [{
                data: dusunData.map(d => d.value),
                backgroundColor: ['#4472c4', '#a9d18e', '#ffc000', '#ed7d31', '#5b9bd5', '#70ad47']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#333',
                    font: { size: 12 },
                    formatter: (value, ctx) => {
                        const label = ctx.chart.data.labels[ctx.dataIndex];
                        const pct = ((value / dusunTotal) * 100).toFixed(1);
                        return label + ' : ' + pct + '%';
                    }
                }
            }
        }
    });
    @endif

    // Chart Agama (Pie)
    @if($statistik['agama']->count() > 0)
    const agamaData = {!! json_encode($statistik['agama']->map(function($a) { return ['label' => $a->agama, 'value' => $a->total]; })->toArray()) !!};
    const agamaTotal = agamaData.reduce((a, b) => a + b.value, 0);
    
    new Chart(document.getElementById('chartAgama'), {
        type: 'pie',
        data: {
            labels: agamaData.map(d => d.label),
            datasets: [{
                data: agamaData.map(d => d.value),
                backgroundColor: ['#4472c4', '#a9d18e', '#ffc000', '#ed7d31', '#5b9bd5', '#70ad47']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#333',
                    font: { size: 12 },
                    formatter: (value, ctx) => {
                        const label = ctx.chart.data.labels[ctx.dataIndex];
                        const pct = ((value / agamaTotal) * 100).toFixed(1);
                        return label + ' : ' + pct + '%';
                    }
                }
            }
        }
    });
    @endif

    // Chart Pekerjaan (Bar)
    @if($statistik['pekerjaan']->count() > 0)
    new Chart(document.getElementById('chartPekerjaan'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($statistik['pekerjaan']->pluck('pekerjaan')->toArray()) !!},
            datasets: [{
                data: {!! json_encode($statistik['pekerjaan']->pluck('total')->toArray()) !!},
                backgroundColor: '#5a8f3e',
                borderRadius: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#333',
                    font: { weight: 'bold', size: 11 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#e5e5e5' }
                },
                x: {
                    grid: { display: false },
                    ticks: { 
                        maxRotation: 45,
                        minRotation: 45,
                        font: { size: 10 }
                    }
                }
            }
        }
    });
    @endif

    // Chart Perkawinan (Pie)
    @if($statistik['perkawinan']->count() > 0)
    const perkawinanData = {!! json_encode($statistik['perkawinan']->map(function($p) { return ['label' => $p->status_perkawinan, 'value' => $p->total]; })->toArray()) !!};
    const perkawinanTotal = perkawinanData.reduce((a, b) => a + b.value, 0);
    
    new Chart(document.getElementById('chartPerkawinan'), {
        type: 'pie',
        data: {
            labels: perkawinanData.map(d => d.label),
            datasets: [{
                data: perkawinanData.map(d => d.value),
                backgroundColor: ['#4472c4', '#a9d18e', '#ffc000', '#ed7d31']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#333',
                    font: { size: 12 },
                    formatter: (value, ctx) => {
                        const label = ctx.chart.data.labels[ctx.dataIndex];
                        const pct = ((value / perkawinanTotal) * 100).toFixed(1);
                        return label + ' : ' + pct + '%';
                    }
                }
            }
        }
    });
    @endif

    // Chart Kelompok Umur (Bar)
    const umurData = {!! json_encode(collect($statistik['kelompok_umur'])->filter(fn($u) => $u['total'] > 0)->values()->toArray()) !!};
    if (umurData.length > 0) {
        new Chart(document.getElementById('chartUmur'), {
            type: 'bar',
            data: {
                labels: umurData.map(u => u.kelompok + ' th'),
                datasets: [{
                    data: umurData.map(u => u.total),
                    backgroundColor: '#5a8f3e',
                    borderRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#333',
                        font: { weight: 'bold', size: 11 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#e5e5e5' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    }
                }
            }
        });
    }
});
</script>
@endsection
