@extends('layouts.app')

@section('title', 'Statistik - Website Resmi Pemerintah Desa')

@php
    use App\Models\Content;
    function getContent($page, $section, $key, $default = '') {
        return Content::getContent($page, $section, $key, $default);
    }
    
    // Get header
    $headerTitle = getContent('data', 'header', 'title', 'Statistik');
    $headerSubtitle = getContent('data', 'header', 'subtitle', 'Data kependudukan dan statistik desa');
    
    // Get statistik kependudukan
    $statJumlahPenduduk = getContent('data', 'statistik', 'jumlah_penduduk', '2.450');
    $statLakiLaki = getContent('data', 'statistik', 'laki_laki', '1.250');
    $statPerempuan = getContent('data', 'statistik', 'perempuan', '1.200');
    $statKepalaKeluarga = getContent('data', 'statistik', 'kepala_keluarga', '650');
@endphp

@section('content')
    <div class="container mx-auto px-4 sm:px-6">
        <div class="mb-6 sm:mb-8 scroll-animate" data-animation="fade-up">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#1e3a8a] mb-2">{{ $headerTitle }}</h1>
            <p class="text-gray-600 text-sm sm:text-base md:text-lg">{{ $headerSubtitle }}</p>
        </div>

        <!-- Statistik Kependudukan (Otomatis dari Database) -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
            <div class="scroll-animate bg-white border border-gray-200 p-4 sm:p-5 md:p-6 text-center hover:border-[#1e3a8a] transition-colors rounded-lg" data-animation="fade-up" data-delay="100">
                <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#1e3a8a] mb-2">{{ number_format($statistik['jumlah_penduduk']) }}</div>
                <div class="text-xs sm:text-sm md:text-base text-gray-600 font-medium">Jumlah Penduduk</div>
            </div>
            <div class="scroll-animate bg-white border border-gray-200 p-4 sm:p-5 md:p-6 text-center hover:border-[#1e3a8a] transition-colors rounded-lg" data-animation="fade-up" data-delay="200">
                <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#1e3a8a] mb-2">{{ number_format($statistik['laki_laki']) }}</div>
                <div class="text-xs sm:text-sm md:text-base text-gray-600 font-medium">Laki-laki</div>
            </div>
            <div class="scroll-animate bg-white border border-gray-200 p-4 sm:p-5 md:p-6 text-center hover:border-[#1e3a8a] transition-colors rounded-lg" data-animation="fade-up" data-delay="300">
                <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#1e3a8a] mb-2">{{ number_format($statistik['perempuan']) }}</div>
                <div class="text-xs sm:text-sm md:text-base text-gray-600 font-medium">Perempuan</div>
            </div>
            <div class="scroll-animate bg-white border border-gray-200 p-4 sm:p-5 md:p-6 text-center hover:border-[#1e3a8a] transition-colors rounded-lg" data-animation="fade-up" data-delay="400">
                <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#1e3a8a] mb-2">{{ number_format($statistik['kepala_keluarga']) }}</div>
                <div class="text-xs sm:text-sm md:text-base text-gray-600 font-medium">Kepala Keluarga</div>
            </div>
        </div>

        <!-- Grafik Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 sm:mb-8">
            <div class="bg-white border border-gray-200 p-4 sm:p-6 md:p-8 rounded-lg">
                <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-[#1e3a8a] mb-4 pb-2 border-b-2 border-[#1e3a8a]">Grafik Jenis Kelamin</h2>
                <div style="position: relative; height: 300px;">
                    <canvas id="chartJenisKelamin"></canvas>
                </div>
            </div>
            <div class="bg-white border border-gray-200 p-4 sm:p-6 md:p-8 rounded-lg">
                <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-[#1e3a8a] mb-4 pb-2 border-b-2 border-[#1e3a8a]">Grafik SD/Sederajat</h2>
                <div style="position: relative; height: 300px;">
                    <canvas id="chartSDSederajat"></canvas>
                </div>
            </div>
        </div>

    <!-- Data Penduduk -->
    <div class="bg-white border border-gray-200 p-6 md:p-8 mb-8 print-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-[#1e3a8a] pb-3 border-b-2 border-[#1e3a8a]">Data Penduduk</h2>
            <button onclick="window.print()" class="hidden print:hidden bg-[#1e3a8a] text-white px-4 py-2 text-sm font-medium hover:bg-blue-900 transition-colors no-print">
                Cetak Data
            </button>
        </div>
        <!-- Skeleton Loading Table -->
        <div class="overflow-x-auto skeleton-wrapper" id="table-skeleton">
            <table class="w-full text-sm md:text-base">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left border border-gray-300"><div class="skeleton skeleton-text"></div></th>
                        <th class="px-4 py-3 text-left border border-gray-300"><div class="skeleton skeleton-text"></div></th>
                        <th class="px-4 py-3 text-left border border-gray-300"><div class="skeleton skeleton-text"></div></th>
                        <th class="px-4 py-3 text-left border border-gray-300"><div class="skeleton skeleton-text"></div></th>
                        <th class="px-4 py-3 text-left border border-gray-300"><div class="skeleton skeleton-text"></div></th>
                        <th class="px-4 py-3 text-left border border-gray-300"><div class="skeleton skeleton-text"></div></th>
                        <th class="px-4 py-3 text-left border border-gray-300"><div class="skeleton skeleton-text"></div></th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td class="px-4 py-3 border border-gray-300"><div class="skeleton skeleton-text"></div></td>
                        <td class="px-4 py-3 border border-gray-300"><div class="skeleton skeleton-text"></div></td>
                        <td class="px-4 py-3 border border-gray-300"><div class="skeleton skeleton-text"></div></td>
                        <td class="px-4 py-3 border border-gray-300"><div class="skeleton skeleton-text"></div></td>
                        <td class="px-4 py-3 border border-gray-300"><div class="skeleton skeleton-text"></div></td>
                        <td class="px-4 py-3 border border-gray-300"><div class="skeleton skeleton-text"></div></td>
                        <td class="px-4 py-3 border border-gray-300"><div class="skeleton skeleton-text"></div></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <!-- Table Content -->
        <div class="overflow-x-auto skeleton-content scroll-animate" id="table-content" data-animation="fade-up">
            <table class="w-full text-sm md:text-base print-table">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left border border-gray-300 font-semibold text-gray-900">No</th>
                        <th class="px-4 py-3 text-left border border-gray-300 font-semibold text-gray-900">NIK</th>
                        <th class="px-4 py-3 text-left border border-gray-300 font-semibold text-gray-900">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left border border-gray-300 font-semibold text-gray-900">Tempat, Tgl Lahir</th>
                        <th class="px-4 py-3 text-left border border-gray-300 font-semibold text-gray-900">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left border border-gray-300 font-semibold text-gray-900">Alamat</th>
                        <th class="px-4 py-3 text-left border border-gray-300 font-semibold text-gray-900">RT/RW</th>
                        <th class="px-4 py-3 text-left border border-gray-300 font-semibold text-gray-900">Pendidikan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penduduk as $index => $p)
                        <tr class="{{ $index % 2 == 0 ? 'hover:bg-gray-50' : 'bg-gray-50 hover:bg-gray-100' }}">
                            <td class="px-4 py-3 border border-gray-300">{{ $penduduk->firstItem() + $index }}</td>
                            <td class="px-4 py-3 border border-gray-300">{{ $p->nik }}</td>
                            <td class="px-4 py-3 border border-gray-300 font-medium">{{ $p->nama }}</td>
                            <td class="px-4 py-3 border border-gray-300">{{ $p->tempat_lahir }}, {{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d M Y') }}</td>
                            <td class="px-4 py-3 border border-gray-300">{{ $p->jenis_kelamin }}</td>
                            <td class="px-4 py-3 border border-gray-300">{{ $p->alamat }}</td>
                            <td class="px-4 py-3 border border-gray-300">{{ $p->rt }}/{{ $p->rw }}</td>
                            <td class="px-4 py-3 border border-gray-300">{{ $p->pendidikan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data penduduk. Silakan tambahkan data dari halaman admin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($penduduk->hasPages())
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span class="font-medium">{{ $penduduk->firstItem() }}</span> - <span class="font-medium">{{ $penduduk->lastItem() }}</span> dari <span class="font-medium">{{ number_format($penduduk->total()) }}</span> data penduduk
                    </p>
                    
                    <!-- Custom Pagination -->
                    <div class="flex items-center gap-1">
                        <!-- Previous Button -->
                        @if($penduduk->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $penduduk->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </a>
                        @endif

                        <!-- Page Numbers -->
                        @php
                            $currentPage = $penduduk->currentPage();
                            $lastPage = $penduduk->lastPage();
                            
                            // Determine which pages to show
                            $pages = [];
                            
                            if ($lastPage <= 7) {
                                // Show all pages if 7 or less
                                for ($i = 1; $i <= $lastPage; $i++) {
                                    $pages[] = $i;
                                }
                            } else {
                                // Always show first page
                                $pages[] = 1;
                                
                                if ($currentPage <= 3) {
                                    // Near the start
                                    for ($i = 2; $i <= 4; $i++) {
                                        $pages[] = $i;
                                    }
                                    $pages[] = '...';
                                    $pages[] = $lastPage;
                                } elseif ($currentPage >= $lastPage - 2) {
                                    // Near the end
                                    $pages[] = '...';
                                    for ($i = $lastPage - 3; $i <= $lastPage; $i++) {
                                        $pages[] = $i;
                                    }
                                } else {
                                    // In the middle
                                    $pages[] = '...';
                                    for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++) {
                                        $pages[] = $i;
                                    }
                                    $pages[] = '...';
                                    $pages[] = $lastPage;
                                }
                            }
                        @endphp
                        
                        <div class="flex items-center gap-1">
                            @foreach($pages as $page)
                                @if($page == '...')
                                    <span class="px-2 text-sm text-gray-400">...</span>
                                @elseif($page == $currentPage)
                                    <span class="px-3 py-2 text-sm font-medium text-white bg-[#1e3a8a] rounded-lg">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $penduduk->url($page) }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        <!-- Next Button -->
                        @if($penduduk->hasMorePages())
                            <a href="{{ $penduduk->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <p class="text-sm text-gray-600 mt-4 italic">
                Menampilkan {{ $penduduk->count() }} data penduduk dari total {{ number_format($statistik['jumlah_penduduk']) }} penduduk.
            </p>
        @endif
    </div>


    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            
            .print-section {
                page-break-inside: avoid;
                margin-bottom: 20px;
            }
            
            .print-table {
                border-collapse: collapse;
            }
            
            .print-table th,
            .print-table td {
                border: 1px solid #000 !important;
                padding: 8px;
            }
            
            .print-table thead {
                background-color: #f3f4f6 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            body {
                background: white !important;
            }
            
            .bg-white {
                background: white !important;
            }
            
            .bg-gray-50 {
                background-color: #f9fafb !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .bg-gray-100 {
                background-color: #f3f4f6 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        .scroll-animate {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .scroll-animate.animate-active {
            opacity: 1;
            transform: translateY(0);
        }
        .scroll-animate[data-animation="fade-up"] {
            opacity: 0;
            transform: translateY(20px);
        }
        .scroll-animate[data-animation="fade-up"].animate-active {
            opacity: 1;
            transform: translateY(0);
        }
        .scroll-animate[data-animation="slide-left"] {
            opacity: 0;
            transform: translateX(-50px);
        }
        .scroll-animate[data-animation="slide-left"].animate-active {
            opacity: 1;
            transform: translateX(0);
        }
        .scroll-animate[data-animation="slide-right"] {
            opacity: 0;
            transform: translateX(50px);
        }
        .scroll-animate[data-animation="slide-right"].animate-active {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        const delay = parseInt(element.dataset.delay) || 0;
                        setTimeout(() => {
                            element.classList.add('animate-active');
                        }, delay);
                        observer.unobserve(element);
                    }
                });
            }, { root: null, rootMargin: '0px', threshold: 0.1 });
            document.querySelectorAll('.scroll-animate').forEach(el => observer.observe(el));
        });

        // Skeleton Loading Management
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const tableSkeleton = document.getElementById('table-skeleton');
                const tableContent = document.getElementById('table-content');
                if (tableSkeleton && tableContent) {
                    tableSkeleton.classList.add('hide');
                    tableContent.classList.add('show');
                }
            }, 800);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart Jenis Kelamin - Pie Chart
            const ctxJenisKelamin = document.getElementById('chartJenisKelamin');
            if (ctxJenisKelamin) {
                const jenisKelaminData = @json($chartData['jenis_kelamin']);
                const jenisKelaminLabels = jenisKelaminData.labels || ['Laki-laki', 'Perempuan'];
                const jenisKelaminValues = jenisKelaminData.data || [0, 0];
                
                new Chart(ctxJenisKelamin, {
                    type: 'pie',
                    data: {
                        labels: jenisKelaminLabels,
                        datasets: [{
                            label: 'Jumlah Penduduk',
                            data: jenisKelaminValues,
                            backgroundColor: [
                                'rgba(30, 58, 138, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                            ],
                            borderColor: [
                                'rgba(30, 58, 138, 1)',
                                'rgba(239, 68, 68, 1)',
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 0
                        },
                        transitions: {
                            active: {
                                animation: {
                                    duration: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        if (total > 0) {
                                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                                            label += context.parsed + ' orang (' + percentage + '%)';
                                        } else {
                                            label += context.parsed + ' orang';
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Chart SD/Sederajat - Doughnut Chart
            const ctxSDSederajat = document.getElementById('chartSDSederajat');
            if (ctxSDSederajat) {
                // Hapus chart lama jika ada
                if (window.chartSDSederajatInstance) {
                    window.chartSDSederajatInstance.destroy();
                }
                
                const sdData = @json($chartData['sd_sederajat'] ?? ['data' => 0, 'total' => 0]);
                const sdCount = parseInt(sdData.data) || 0;
                const totalPenduduk = parseInt(sdData.total) || 0;
                const nonSD = Math.max(0, totalPenduduk - sdCount);
                
                // Debug log (bisa dihapus setelah testing)
                console.log('SD/Sederajat Data:', {
                    sdCount: sdCount,
                    totalPenduduk: totalPenduduk,
                    nonSD: nonSD,
                    rawData: sdData
                });
                
                if (totalPenduduk > 0) {
                    window.chartSDSederajatInstance = new Chart(ctxSDSederajat, {
                        type: 'doughnut',
                        data: {
                            labels: ['SD/Sederajat', 'Lainnya'],
                            datasets: [{
                                label: 'Jumlah Penduduk',
                                data: [sdCount, nonSD],
                                backgroundColor: [
                                    'rgba(34, 197, 94, 0.8)', // Green for SD/Sederajat
                                    'rgba(229, 231, 235, 0.8)', // Gray for Lainnya
                                ],
                                borderColor: [
                                    'rgba(34, 197, 94, 1)',
                                    'rgba(229, 231, 235, 1)',
                                ],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                duration: 0
                            },
                            transitions: {
                                active: {
                                    animation: {
                                        duration: 0
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            if (total > 0) {
                                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                                label += context.parsed + ' orang (' + percentage + '%)';
                                            } else {
                                                label += context.parsed + ' orang';
                                            }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                } else {
                    ctxSDSederajat.parentElement.innerHTML = '<div class="text-center py-8 text-gray-500">Belum ada data penduduk. Silakan tambahkan data dari halaman admin.</div>';
                }
            }
        });
    </script>
    <style>
        .skeleton-content {
            display: none;
        }
        .skeleton-content.show {
            display: block;
        }
        .skeleton-wrapper.hide {
            display: none;
        }
    </style>
    </div>
@endsection
