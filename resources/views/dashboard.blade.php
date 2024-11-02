<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Today's Sales Card --}}
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
                                    <dt class="truncate text-sm font-medium text-gray-500">Today's Sales</dt>
                                    <dd class="text-lg font-medium text-gray-900" data-sales-today>Rp 0</dd>
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
                                    <dt class="truncate text-sm font-medium text-gray-500">This Month's Sales</dt>
                                    <dd class="text-lg font-medium text-gray-900" data-sales-month>Rp 0</dd>
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
                                    <dt class="truncate text-sm font-medium text-gray-500">Total Products</dt>
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
                                    <dt class="truncate text-sm font-medium text-gray-500">Low Stock Alerts</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ number_format($lowStockProducts) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    @if ($lowStockProducts > 0)
                        <div class="bg-red-50 px-5 py-2">
                            <a href="{{ route('products.index') }}" class="text-sm text-red-600 hover:text-red-800">View
                                all alerts →</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Charts Section --}}
            <div class="mt-8 grid grid-cols-1 gap-4 lg:grid-cols-2">
                {{-- Sales Chart --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Sales Last 7 Days</h3>
                        <div class="mt-2">
                            <div class="h-[300px]">
                                <canvas id="dailySalesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Top Products Chart --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Top Selling Products</h3>
                        <div class="mt-2">
                            <div class="h-[300px]">
                                <canvas id="topProductsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tables Section --}}
            <div class="mt-8 grid grid-cols-1 gap-4 lg:grid-cols-2">
                {{-- Low Stock Table --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Low Stock Products</h3>
                            @if ($lowStockProducts > 0)
                                <a href="{{ route('products.index') }}"
                                    class="text-sm text-blue-600 hover:text-blue-900">View all →</a>
                            @endif
                        </div>
                        <div class="mt-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Product</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Current Stock</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Min Stock</th>
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
                                                        Low Stock
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="px-6 py-4 text-center text-sm text-gray-500">
                                                    No low stock products found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Transactions Table --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Transactions</h3>
                            <a href="{{ route('sales.index') }}"
                                class="text-sm text-blue-600 hover:text-blue-900">View all →</a>
                        </div>
                        <div class="mt-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Invoice</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Date</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Amount</th>
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
                                                            Void
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                                            Completed
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="px-6 py-4 text-center text-sm text-gray-500">
                                                    No transactions found
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
    @push('scripts')
        <script>
            // Format Rupiah
            function formatRupiah(number) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
            }
            // Animate Numbers
            function animateValue(element, start, end, duration) {
                if (start === end) return;
                const range = end - start;
                let current = start;
                const increment = end > start ? 1 : -1;
                const stepTime = Math.abs(Math.floor(duration / range));
                const timer = setInterval(() => {
                    current += increment;
                    element.textContent = formatRupiah(current);
                    if (current === end) {
                        clearInterval(timer);
                    }
                }, stepTime);
            }

            // Daily Sales Chart
            const dailySalesChart = new Chart(
                document.getElementById('dailySalesChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: @json($dailySales->pluck('date')->map(fn($date) => Carbon\Carbon::parse($date)->format('d/m'))),
                        datasets: [{
                            label: 'Daily Sales',
                            data: @json($dailySales->pluck('total')),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        return formatRupiah(context.raw);
                                    }
                                },
                                padding: 10,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return formatRupiah(value);
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                }
            );

            // Top Products Chart
            const topProductsChart = new Chart(
                document.getElementById('topProductsChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: @json($topProducts->pluck('name')),
                        datasets: [{
                            label: 'Units Sold',
                            data: @json($topProducts->pluck('sale_details_sum_quantity')),
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)', // Blue
                                'rgba(16, 185, 129, 0.8)', // Green
                                'rgba(245, 158, 11, 0.8)', // Yellow
                                'rgba(239, 68, 68, 0.8)', // Red
                                'rgba(139, 92, 246, 0.8)' // Purple
                            ],
                            borderColor: [
                                'rgb(59, 130, 246)',
                                'rgb(16, 185, 129)',
                                'rgb(245, 158, 11)',
                                'rgb(239, 68, 68)',
                                'rgb(139, 92, 246)'
                            ],
                            borderWidth: 1,
                            borderRadius: 4,
                            maxBarThickness: 50
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        return `${context.raw} units sold`;
                                    }
                                },
                                padding: 10,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                }
            );

            // Animate numbers on load
            document.addEventListener('DOMContentLoaded', function() {
                // Animate today's sales
                const todaySalesEl = document.querySelector('[data-sales-today]');
                animateValue(todaySalesEl, 0, {{ $totalSalesToday }}, 1000);

                // Animate monthly sales
                const monthlySalesEl = document.querySelector('[data-sales-month]');
                animateValue(monthlySalesEl, 0, {{ $totalSalesThisMonth }}, 1500);

                // Highlight low stock rows
                document.querySelectorAll('.low-stock-row').forEach(row => {
                    const stock = parseInt(row.dataset.stock);
                    const minStock = parseInt(row.dataset.minStock);
                    if (stock <= minStock) {
                        row.classList.add('bg-red-50');
                    }
                });
            });

            // Live clock
            function updateClock() {
                const now = new Date();
                const clockEl = document.getElementById('live-clock');
                if (clockEl) {
                    clockEl.textContent = now.toLocaleTimeString('id-ID');
                }
            }
            setInterval(updateClock, 1000);
            updateClock();

            // Auto refresh dashboard
            setTimeout(function() {
                window.location.reload();
            }, 300000); // Refresh every 5 minutes
        </script>
    @endpush
</x-app-layout>
