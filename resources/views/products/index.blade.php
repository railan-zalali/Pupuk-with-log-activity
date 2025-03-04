<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Products') }}
            </h2>
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('products.create') }}"
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Add New Product
                    </a>
                </div>
                <div class="w-64 ml-4">
                    <input type="text" id="searchInput" placeholder="Search products..."
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        autofocus>
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

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Kode</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Nama</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Kategori</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Stok</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Harga</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $product->code }}</td>
                                        <td class="px-6 py-4">{{ $product->name }}</td>
                                        <td class="px-6 py-4">{{ $product->category->name }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="@if ($product->stock <= $product->min_stock) text-red-600 font-bold @endif">
                                                {{ $product->stock }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">Rp
                                            {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 space-x-2">
                                            <a href="{{ route('products.show', $product) }}"
                                                class="text-blue-600 hover:text-blue-900">Lihat</a>
                                            <a href="{{ route('products.edit', $product) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada produk ditemukan.
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
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada produk ditemukan.
                        </td>
                    </tr>
                    `;
                                        return;
                                    }

                                    products.forEach(product => {
                                        const stockClass = product.stock <= product
                                            .min_stock ? 'text-red-600 font-bold' : '';
                                        tbody.innerHTML += `
                    <tr>
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
                    <td colspan="6" class="px-6 py-4 text-center text-red-500">
                        Kesalahan memuat data. Silakan coba lagi.
                    </td>
                    </tr>
                `;
                                });
                        } else if (searchQuery.length === 0) {
                            window.location.reload();
                        }
                    }, 300);
                });
            });
        </script>
    @endpush
</x-app-layout>
