<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Log Aktivitas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header -->
                    <div
                        class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Log Aktivitas #{{ $activityLog->id }}</h2>
                            <p class="text-sm text-gray-500">{{ $activityLog->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>

                        <div class="mt-4 sm:mt-0 flex space-x-2">
                            @if (auth()->user()->hasPermission('delete_activity_logs'))
                                <form action="{{ route('activity_logs.destroy', $activityLog) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center rounded-md bg-red-50 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus log aktivitas ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            @endif
                            <button onclick="window.history.back()"
                                class="inline-flex items-center rounded-md bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali
                            </button>
                        </div>
                    </div>

                    <!-- Informasi Log -->
                    <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
                        <!-- Informasi Dasar -->
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi Dasar
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 shadow-sm">
                                <dl class="space-y-4">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">ID</dt>
                                        <dd class="text-sm font-medium text-gray-900">{{ $activityLog->id }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Waktu</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            {{ $activityLog->created_at->format('d/m/Y H:i:s') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            {{ $activityLog->ip_address ?? 'Tidak ada' }}</dd>
                                    </div>
                                    <div class="pt-2 border-t border-gray-200">
                                        <dt class="text-sm font-medium text-gray-500 mb-1">User Agent</dt>
                                        <dd class="text-sm text-gray-900 break-words">
                                            {{ $activityLog->user_agent ?? 'Tidak ada' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Detail Aktivitas -->
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Detail Aktivitas
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 shadow-sm">
                                <dl class="space-y-4">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Pengguna</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            {{ $activityLog->user ? $activityLog->user->name : 'System' }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Tipe</dt>
                                        <dd class="text-sm">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst($activityLog->type) }}
                                            </span>
                                        </dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Modul</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            {{ ucfirst($activityLog->module) }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Aksi</dt>
                                        <dd class="text-sm">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ App\Helpers\ActivityLogHelper::getActivityBadgeColor($activityLog->action) }}-100 text-{{ App\Helpers\ActivityLogHelper::getActivityBadgeColor($activityLog->action) }}-800">
                                                {{ ucfirst(str_replace('_', ' ', $activityLog->action)) }}
                                            </span>
                                        </dd>
                                    </div>
                                    <div class="pt-2 border-t border-gray-200">
                                        <dt class="text-sm font-medium text-gray-500 mb-1">Deskripsi</dt>
                                        <dd
                                            class="text-sm text-gray-900 bg-white p-2 rounded-md border border-gray-200">
                                            {{ $activityLog->description }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Referensi -->
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Referensi Data
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 shadow-sm">
                                @if ($activityLog->reference_id && $activityLog->reference_type)
                                    <dl class="space-y-4">
                                        <div class="flex justify-between">
                                            <dt class="text-sm font-medium text-gray-500">Tipe</dt>
                                            <dd class="text-sm font-medium text-gray-900">
                                                {{ class_basename($activityLog->reference_type) }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm font-medium text-gray-500">ID</dt>
                                            <dd class="text-sm font-medium text-gray-900">
                                                {{ $activityLog->reference_id }}</dd>
                                        </div>
                                        <div class="pt-2 border-t border-gray-200">
                                            <dt class="text-sm font-medium text-gray-500 mb-1">Lihat Data</dt>
                                            <dd class="text-sm">
                                                <a href="#"
                                                    class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                    Buka Data Referensi
                                                </a>
                                            </dd>
                                        </div>
                                    </dl>
                                @else
                                    <div class="py-8 text-center">
                                        <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-gray-500 font-medium">Tidak ada data referensi</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Data Perubahan -->
                    <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Data Sebelum Perubahan -->
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Data Sebelum Perubahan
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 shadow-sm">
                                @if ($activityLog->before_data)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Atribut</th>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($activityLog->before_data as $key => $value)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-4 py-2 text-sm font-medium text-gray-900">
                                                            {{ $key }}</td>
                                                        <td class="px-4 py-2 text-sm text-gray-700">
                                                            @if (is_array($value))
                                                                <pre class="bg-gray-100 p-2 rounded text-xs overflow-auto">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                            @else
                                                                {{ $value }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="py-8 text-center">
                                        <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-gray-500 font-medium">Tidak ada data sebelum perubahan</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Data Setelah Perubahan -->
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                                Data Setelah Perubahan
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 shadow-sm">
                                @if ($activityLog->after_data)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Atribut</th>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($activityLog->after_data as $key => $value)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-4 py-2 text-sm font-medium text-gray-900">
                                                            {{ $key }}</td>
                                                        <td class="px-4 py-2 text-sm text-gray-700">
                                                            @if (is_array($value))
                                                                <pre class="bg-gray-100 p-2 rounded text-xs overflow-auto">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                            @else
                                                                {{ $value }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="py-8 text-center">
                                        <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-gray-500 font-medium">Tidak ada data setelah perubahan</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
