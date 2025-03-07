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

                    <div class="overflow-x-auto relative bg-white rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 rounded-md">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                                        Gambar
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                                        Kode
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                                        Nama
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                                        Kategori
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                                        Stok
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                                        Harga
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div
                                                class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden shadow-sm">
                                                @if ($product->image_path)
                                                    <img src="{{ Storage::url($product->image_path) }}"
                                                        alt="{{ $product->name }}" class="h-full w-full object-cover">
                                                @else
                                                    <svg class="h-6 w-6 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                                            {{ $product->code }}</td>
                                        <td class="px-6 py-4 text-gray-900">{{ $product->name }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $product->category->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($product->stock <= $product->min_stock)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    {{ $product->stock }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $product->stock }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-medium">Rp
                                            {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 space-x-2">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('products.show', $product) }}"
                                                    class="text-blue-600 hover:text-blue-900 transition-colors inline-flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat
                                                </a>

                                                <a href="{{ route('products.edit', $product) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 transition-colors inline-flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>

                                                <form action="{{ route('products.destroy', $product) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transition-colors inline-flex items-center"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="h-10 w-10 text-gray-400 mb-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-gray-500 text-lg font-medium">Tidak ada produk
                                                    ditemukan.</p>
                                                <p class="text-gray-400 text-sm mt-1">Tambahkan produk baru untuk
                                                    memulai.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const tbody = document.querySelector('tbody');
                let debounceTimer;

                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        const searchQuery = this.value;

                        if (searchQuery.length >= 2) {
                            fetch(`/search/products?query=${encodeURIComponent(searchQuery)}`)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Respon jaringan tidak ok');
                                    }
                                    return response.json();
                                })
                                .then(response => {
                                    const products = response.data;
                                    tbody.innerHTML = ''; // Hapus konten tabel saat ini

                                    if (products.length === 0) {
                                        tbody.innerHTML = `
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada produk ditemukan.
                                </td>
                            </tr>
                            `;
                                        return;
                                    }

                                    products.forEach(product => {
                                        const stockClass = product.stock <= product
                                            .min_stock ? 'text-red-600 font-bold' : '';

                                        // Image HTML
                                        let imageHtml =
                                            `
                                                <div class="flex-shrink-0 h-12 w-12 rounded-md bg-gray-100 flex items-center justify-center overflow-hidden">`;

                                        if (product.image_path) {
                                            imageHtml +=
                                                `<img src="/storage/${product.image_path}" alt="${product.name}" class="h-full w-full object-cover">`;
                                        } else {
                                            imageHtml += `<svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>`;
                                        }

                                        imageHtml += `</div>`;

                                        tbody.innerHTML += `
                        <tr>
                            <td class="whitespace-nowrap px-6 py-2">${imageHtml}</td>
                            <td class="whitespace-nowrap px-6 py-4">${product.code}</td>
                            <td class="px-6 py-4">${product.name}</td>
                            <td class="px-6 py-4">${product.category.name}</td>
                            <td class="px-6 py-4">
                            <span class="${stockClass}">
                                ${product.stock}
                            </span>
                            </td>
                            <td class="px-6 py-4">Rp ${new Intl.NumberFormat('id-ID').format(product.selling_price)}</td>
                            <td class="whitespace-nowrap px-6 py-4 space-x-2">
                            <a href="/products/${product.id}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            <a href="/products/${product.id}/edit" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <button onclick="deleteProduct(${product.id})" class="text-red-600 hover:text-red-900">
                                Hapus
                            </button>
                            </td>
                        </tr>
                        `;

                                    });
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    tbody.innerHTML = `
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Terjadi kesalahan saat mencari produk.
                                        </td>
                                    </tr>
                                    `;
                                });
                        }
                    }, 300); // Delay 300ms untuk debouncing
                });
            });

            // Fungsi untuk menghapus produk
            function deleteProduct(productId) {
                if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/products/${productId}`;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;

                    form.appendChild(methodInput);
                    form.appendChild(csrfInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        </script>
    @endpush
</x-app-layout>
