<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Customers') }}
        </h2>
    </x-slot>

    {{-- Add these styles in the head --}}
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    @endpush

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('customers.create') }}"
                            class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">
                            Add New Customer
                        </a>
                    </div>

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

                    <div class="overflow-x-auto">
                        <table id="customers-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500">
                                        NIK</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500">
                                        Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500">
                                        Address</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500">
                                        Village</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500">
                                        District</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500">
                                        Regency</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500">
                                        Province</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500">
                                        Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add these scripts before closing body tag --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#customers-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('customers.index') }}",
                    columns: [{
                            data: 'nik',
                            name: 'nik'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'alamat',
                            name: 'alamat'
                        },
                        {
                            data: 'desa_nama',
                            name: 'desa_nama'
                        },
                        {
                            data: 'kecamatan_nama',
                            name: 'kecamatan_nama'
                        },
                        {
                            data: 'kabupaten_nama',
                            name: 'kabupaten_nama'
                        },
                        {
                            data: 'provinsi_nama',
                            name: 'provinsi_nama'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    dom: 'Bfrtip',
                    layout: {
                        topStart: {
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ]
                        }
                    },
                });
            });
        </script>
    @endpush
</x-app-layout>
