<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
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

            @if (session('error'))
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
                            <p class="text-sm font-medium text-red-800">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Product Information</h3>
                            <dl class="mt-4 space-y-4">
                                <div>
                                    <dt class="font-medium text-gray-500">Code</dt>
                                    <dd class="mt-1">{{ $product->code }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1">{{ $product->name }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Category</dt>
                                    <dd class="mt-1">{{ $product->category->name }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1">{{ $product->description ?? 'No description' }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Stock & Price Information</h3>
                            <dl class="mt-4 space-y-4">
                                <div>
                                    <dt class="font-medium text-gray-500">Current Stock</dt>
                                    <dd class="mt-1 @if ($product->stock <= $product->min_stock) text-red-600 font-bold @endif">
                                        {{ $product->stock }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Minimum Stock</dt>
                                    <dd class="mt-1">{{ $product->min_stock }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Purchase Price</dt>
                                    <dd class="mt-1">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Selling Price</dt>
                                    <dd class="mt-1">Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Stock Adjustment Form -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Stock Adjustment</h3>
                        <form action="{{ route('products.updateStock', $product) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div>
                                    <x-input-label for="adjustment_type" value="Adjustment Type" />
                                    <select id="adjustment_type" name="adjustment_type"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                        <option value="add">Add Stock</option>
                                        <option value="subtract">Subtract Stock</option>
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="quantity" value="Quantity" />
                                    <x-text-input id="quantity" name="quantity" type="number"
                                        class="mt-1 block w-full" min="1" required />
                                </div>

                                <div>
                                    <x-input-label for="notes" value="Notes" />
                                    <x-text-input id="notes" name="notes" type="text" class="mt-1 block w-full"
                                        placeholder="Optional notes" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-primary-button>
                                    Adjust Stock
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Stock Movement History -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Stock Movement History</h3>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Type</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Quantity</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Before</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            After</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Reference</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse ($product->stockMovements as $movement)
                                        <tr>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                {{ $movement->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                                    {{ $movement->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($movement->type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">{{ $movement->quantity }}</td>
                                            <td class="px-6 py-4">{{ $movement->before_stock }}</td>
                                            <td class="px-6 py-4">{{ $movement->after_stock }}</td>
                                            <td class="px-6 py-4">{{ ucfirst($movement->reference_type) }}</td>
                                            <td class="px-6 py-4">{{ $movement->notes ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                                No stock movements found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <x-secondary-button onclick="window.history.back()">
                            Back
                        </x-secondary-button>
                        <a href="{{ route('products.edit', $product) }}"
                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            Edit Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
