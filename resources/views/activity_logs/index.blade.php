<x-app-layout>
    <!-- Header yang diperbarui untuk index.blade.php -->
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold leading-tight text-gray-800">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0v10l-8 4m0-10L4 7m8 4v10" />
                        </svg>
                        {{ __('Products') }}
                    </span>
                </h2>
                <p class="mt-1 text-sm text-gray-600">Kelola semua produk Anda dalam satu tempat</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="w-full sm:w-auto order-2 sm:order-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="searchInput" placeholder="Cari produk..."
                            class="pl-10 pr-4 py-2 w-full sm:w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            autofocus>
                    </div>
                </div>

                <div class="w-full sm:w-auto order-1 sm:order-2">
                    <a href="{{ route('products.create') }}"
                        class="flex justify-center items-center w-full sm:w-auto rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Produk
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Activity Logs Section -->
                    <div class="mt-8">
                        <div class="overflow-hidden rounded-lg bg-white shadow-sm border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold leading-6 text-gray-900 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Aktivitas Terbaru
                                    </h3>
                                    <a href="{{ route('activity_logs.index') }}"
                                        class="text-sm text-blue-600 hover:text-blue-900 flex items-center">
                                        <span>Lihat semua</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="mt-2">
                                    <div class="divide-y divide-gray-200">
                                        @forelse($latestLogs as $log)
                                            <div class="py-3 flex items-start">
                                                <div class="flex-shrink-0">
                                                    <span
                                                        class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-{{ ActivityLogHelper::getActivityBadgeColor($log->action) }}-100 text-{{ ActivityLogHelper::getActivityBadgeColor($log->action) }}-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            @switch(ActivityLogHelper::getActivityIcon($log->action))
                                                                @case('plus')
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                                @break

                                                                <!-- Case statements remain the same -->
                                                            @endswitch
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="ml-4 flex-1">
                                                    <a href="{{ route('activity_logs.show', $log) }}"
                                                        class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                        {{ ucfirst($log->type) }} - {{ ucfirst($log->module) }}
                                                    </a>
                                                    <p class="mt-1 text-sm text-gray-600">
                                                        {{ Str::limit($log->description, 100) }}
                                                    </p>
                                                    <p class="mt-1 text-xs text-gray-500">
                                                        {{ $log->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                            @empty
                                                <div class="py-8 text-center">
                                                    <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p class="text-gray-500 font-medium">Belum ada aktivitas yang tercatat
                                                    </p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>
