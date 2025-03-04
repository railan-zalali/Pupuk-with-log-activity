<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Ada kesalahan dalam pengiriman Anda</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="category_id" value="Kategori" />
                                <select id="category_id" name="category_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="code" value="Kode Produk" />
                                <x-text-input id="code" name="code" type="text"
                                    class="mt-1 block w-full bg-gray-100" :value="$productCode" readonly />
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="name" value="Nama Produk" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" value="Deskripsi" />
                                <textarea id="description" name="description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="purchase_price" value="Harga Beli" />
                                <x-text-input id="purchase_price" name="purchase_price" type="number"
                                    class="mt-1 block w-full" :value="old('purchase_price')" required />
                                <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="selling_price" value="Harga Jual" />
                                <x-text-input id="selling_price" name="selling_price" type="number"
                                    class="mt-1 block w-full" :value="old('selling_price')" required />
                                <x-input-error :messages="$errors->get('selling_price')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="stock" value="Stok Awal" />
                                <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full"
                                    :value="old('stock', 0)" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="min_stock" value="Stok Minimum" />
                                <x-text-input id="min_stock" name="min_stock" type="number" class="mt-1 block w-full"
                                    :value="old('min_stock', 0)" required />
                                <x-input-error :messages="$errors->get('min_stock')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <x-secondary-button type="button" onclick="window.history.back()">
                                Batal
                            </x-secondary-button>
                            <x-primary-button>
                                Buat Produk
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
