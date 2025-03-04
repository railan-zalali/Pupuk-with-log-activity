<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Kartu Ringkasan --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Kartu Penjualan Hari Ini --}}
                <div class="overflow-hidden rounded-lg bg-white shadow hover:shadow-lg transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-blue-100 rounded-full">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Penjulaan Harian</dt>
                                    <dd class="text-lg font-medium text-gray-900">Rp
                                        {{ number_format($totalSalesToday, 0, ',', '.') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Monthly Sales Card --}}
                <div class="overflow-hidden rounded-lg bg-white shadow hover:shadow-lg transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-green-100 rounded-full">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Penjualan Bulanan</dt>
                                    <dd class="text-lg font-medium text-gray-900">Rp
                                        {{ number_format($totalSalesThisMonth, 0, ',', '.') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Products Card --}}
                <div class="overflow-hidden rounded-lg bg-white shadow hover:shadow-lg transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-indigo-100 rounded-full">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Total Produk</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ number_format($totalProducts) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Low Stock Card --}}
                <div class="overflow-hidden rounded-lg bg-white shadow hover:shadow-lg transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-red-100 rounded-full">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Stok Produk Rendah</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ number_format($lowStockProducts) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    @if ($lowStockProducts > 0)
                        <div class="bg-red-50 px-5 py-2">
                            <a href="{{ route('products.index') }}"
                                class="text-sm text-red-600 hover:text-red-800">Lihat
                                semua peringatan →</a>
                        </div>
                    @endif
                </div>
                {{-- Kartu Kredit --}}
                <div class="overflow-hidden rounded-lg bg-white shadow hover:shadow-lg transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-orange-100 rounded-full">
                                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Kredit Bulanan</dt>
                                    <dd class="text-lg font-medium text-gray-900">Rp
                                        {{ number_format($totalCreditAmount, 0, ',', '.') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    @if ($totalUpcomingCredits > 0)
                        <div class="bg-orange-50 px-5 py-2">
                            <a href="{{ route('sales.credit') }}"
                                class="text-sm text-orange-600 hover:text-orange-800">Lihat semua kredit →</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bagian Grafik --}}
            <div class="mt-8 grid grid-cols-1 gap-4 lg:grid-cols-2">
                {{-- Grafik Penjualan --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Penjualan Mingguan</h3>
                        <div class="mt-2">
                            <div class="h-96">
                                <canvas id="dailySalesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Grafik Produk Terlaris --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Produk Terlaris</h3>
                        <div class="mt-2">
                            <div class="h-96">
                                <canvas id="topProductsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Tabel --}}
            <div class="mt-8 grid grid-cols-1 gap-4 lg:grid-cols-2">
                {{-- Tabel Stok Rendah --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Stok Produk Rendah</h3>
                            @if ($lowStockProducts > 0)
                                <a href="{{ route('products.index') }}"
                                    class="text-sm text-blue-600 hover:text-blue-900">Lihat semua →</a>
                            @endif
                        </div>
                        <div class="mt-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Produk</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Stok Saat Ini</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Stok Minimum</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @forelse($lowStockAlerts as $product)
                                            <tr>
                                                <td class="whitespace-nowrap px-6 py-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{ $product->code }}</div>
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                                    <span class="text-red-600">{{ $product->stock }}</span>
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                    {{ $product->min_stock }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                    <span
                                                        class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
                                                        Stok Rendah
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="px-6 py-4 text-center text-sm text-gray-500">
                                                    Tidak Ada Stok Produk Rendah
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Transaksi Terbaru --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Transaksi Terbaru</h3>
                            <a href="{{ route('sales.index') }}"
                                class="text-sm text-blue-600 hover:text-blue-900">Lihat semua →</a>
                        </div>
                        <div class="mt-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Faktur</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Tanggal</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Jumlah</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @forelse($recentTransactions as $transaction)
                                            <tr>
                                                <td class="whitespace-nowrap px-6 py-4">
                                                    <a href="{{ route('sales.show', $transaction) }}"
                                                        class="text-blue-600 hover:text-blue-900">
                                                        {{ $transaction->invoice_number }}
                                                    </a>
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                    @if ($transaction->trashed())
                                                        <span
                                                            class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
                                                            Batal
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                                            Selesai
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="px-6 py-4 text-center text-sm text-gray-500">
                                                    Tidak ada transaksi ditemukan
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Upcoming Credits Table --}}
                <div class="mt-8">
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Kredit Jatuh Tempo Dalam 30
                                    Hari</h3>
                                @if ($totalUpcomingCredits > 0)
                                    <a href="{{ route('sales.credit') }}"
                                        class="text-sm text-blue-600 hover:text-blue-900">Lihat semua →</a>
                                @endif
                            </div>
                            <div class="mt-4">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                    Faktur</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                    Pelanggan</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                    Tanggal Jatuh Tempo</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                    Jumlah Terhutang</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                    Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @forelse($upcomingCredits as $credit)
                                                <tr>
                                                    <td class="whitespace-nowrap px-6 py-4">
                                                        <a href="{{ route('sales.show', $credit) }}"
                                                            class="text-blue-600 hover:text-blue-900">
                                                            {{ $credit->invoice_number }}
                                                        </a>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                        {{ $credit->customer->nama ?? 'Pelanggan Tidak Diketahui' }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                        {{ \Carbon\Carbon::parse($credit->due_date)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                                        Rp {{ number_format($credit->remaining_amount, 0, ',', '.') }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        @if (\Carbon\Carbon::parse($credit->due_date)->isPast())
                                                            <span
                                                                class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
                                                                Terlambat
                                                            </span>
                                                        @elseif(\Carbon\Carbon::parse($credit->due_date)->diffInDays(now()) <= 7)
                                                            <span
                                                                class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">
                                                                Segera Jatuh Tempo
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex rounded-full bg-orange-100 px-2 text-xs font-semibold leading-5 text-orange-800">
                                                                Akan Datang
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5"
                                                        class="px-6 py-4 text-center text-sm text-gray-500">
                                                        Tidak ada kredit yang akan datang ditemukan
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Format Rupiah
            function formatRupiah(number) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
            }

            // Daily Sales Chart
            const dailySalesChart = new Chart(
                document.getElementById('dailySalesChart'), {
                    type: 'line',
                    data: {
                        labels: @json($dailySales->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d/m'))),
                        datasets: [{
                            label: 'Penjualan Harian',
                            data: @json($dailySales->pluck('total')),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return formatRupiah(context.raw);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return formatRupiah(value);
                                    }
                                }
                            }
                        }
                    }
                }
            );

            // Top Products Chart
            const topProductsChart = new Chart(
                document.getElementById('topProductsChart'), {
                    type: 'bar',
                    data: {
                        labels: @json($topProducts->pluck('name')),
                        datasets: [{
                            label: 'Unit Terjual',
                            data: @json($topProducts->pluck('total_sold')), // Changed from sale_details_sum_quantity
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(245, 158, 11, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(139, 92, 246, 0.8)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                }
            );
        </script>
    @endpush
</x-app-layout>
