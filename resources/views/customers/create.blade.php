<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Add New Customer') }}
            </h2>
            <!-- Import Form -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-0 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data"
                        class="flex items-center">
                        @csrf
                        <div>
                            <x-input-label for="excel_file" :value="__('Import Customers from Excel')" />
                            <input id="excel_file" name="excel_file" type="file" accept=".xlsx,.xls"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0 file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                required />
                            <x-input-error :messages="$errors->get('excel_file')" class="mt-2" />
                        </div>

                        <div class="ml-4">
                            <x-primary-button>
                                {{ __('Import Customers') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="nik" :value="__('NIK')" />
                                <x-text-input id="nik" name="nik" type="number" class="mt-1 block w-full"
                                    :value="old('nik')" required />
                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="nama" :value="__('Nama')" />
                                <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full"
                                    :value="old('nama')" required />
                                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <textarea id="alamat" name="alamat" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alamat') }}</textarea>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="provinsi" :value="__('Provinsi')" />
                                <select id="provinsi" name="provinsi_id" class="mt-1 block w-full select2" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <input type="hidden" name="provinsi_nama" id="provinsi_nama">
                                <x-input-error :messages="$errors->get('provinsi_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kabupaten" :value="__('Kabupaten')" />
                                <select id="kabupaten" name="kabupaten_id" class="mt-1 block w-full select2" required
                                    disabled>
                                    <option value="">Pilih Kabupaten</option>
                                </select>
                                <input type="hidden" name="kabupaten_nama" id="kabupaten_nama">
                                <x-input-error :messages="$errors->get('kabupaten_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                                <select id="kecamatan" name="kecamatan_id" class="mt-1 block w-full select2" required
                                    disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                <input type="hidden" name="kecamatan_nama" id="kecamatan_nama">
                                <x-input-error :messages="$errors->get('kecamatan_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="desa" :value="__('Desa')" />
                                <select id="desa" name="desa_id" class="mt-1 block w-full select2" required
                                    disabled>
                                    <option value="">Pilih Desa</option>
                                </select>
                                <input type="hidden" name="desa_nama" id="desa_nama">
                                <x-input-error :messages="$errors->get('desa_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-primary-button>
                                {{ __('Create Customer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    theme: 'classic',
                    width: '100%'
                });

                // Load Provinsi
                $.get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', function(provinces) {
                    provinces.forEach(function(province) {
                        $('#provinsi').append(new Option(province.name, province.id));
                    });
                });

                // Event Provinsi Change
                $('#provinsi').on('change', function() {
                    $('#kabupaten').empty().append(new Option('Pilih Kabupaten', '')).prop('disabled', true);
                    $('#kecamatan').empty().append(new Option('Pilih Kecamatan', '')).prop('disabled', true);
                    $('#desa').empty().append(new Option('Pilih Desa', '')).prop('disabled', true);

                    if (this.value) {
                        $('#provinsi_nama').val($('#provinsi option:selected').text());
                        loadKabupaten(this.value);
                    }
                });

                // Event Kabupaten Change
                $('#kabupaten').on('change', function() {
                    $('#kecamatan').empty().append(new Option('Pilih Kecamatan', '')).prop('disabled', true);
                    $('#desa').empty().append(new Option('Pilih Desa', '')).prop('disabled', true);

                    if (this.value) {
                        $('#kabupaten_nama').val($('#kabupaten option:selected').text());
                        loadKecamatan(this.value);
                    }
                });

                // Event Kecamatan Change
                $('#kecamatan').on('change', function() {
                    $('#desa').empty().append(new Option('Pilih Desa', '')).prop('disabled', true);

                    if (this.value) {
                        $('#kecamatan_nama').val($('#kecamatan option:selected').text());
                        loadDesa(this.value);
                    }
                });

                // Event Desa Change
                $('#desa').on('change', function() {
                    if (this.value) {
                        $('#desa_nama').val($('#desa option:selected').text());
                    }
                });

                function loadKabupaten(provinceId) {
                    $.get(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`, function(
                        regencies) {
                        $('#kabupaten').prop('disabled', false);
                        regencies.forEach(function(regency) {
                            $('#kabupaten').append(new Option(regency.name, regency.id));
                        });
                    });
                }

                function loadKecamatan(regencyId) {
                    $.get(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`, function(
                        districts) {
                        $('#kecamatan').prop('disabled', false);
                        districts.forEach(function(district) {
                            $('#kecamatan').append(new Option(district.name, district.id));
                        });
                    });
                }

                function loadDesa(districtId) {
                    $.get(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`, function(
                        villages) {
                        $('#desa').prop('disabled', false);
                        villages.forEach(function(village) {
                            $('#desa').append(new Option(village.name, village.id));
                        });
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
