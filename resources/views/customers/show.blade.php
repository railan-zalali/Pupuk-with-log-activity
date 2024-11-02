<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Customer Details') }}
            </h2>
            <a href="{{ route('customers.edit', $customer) }}"
                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                Edit Customer
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        {{-- Customer Information --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                            <dl class="mt-4 space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->name }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->phone ?? '-' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->email ?? '-' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                            {{ $customer->type === 'wholesale' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($customer->type) }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->address ?? '-' }}</dd>
                                </div>

                                @if ($customer->notes)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $customer->notes }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        {{-- Sales Summary --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Sales Summary</h3>
                            <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                                    <dt class="truncate text-sm font-medium text-gray-500">Total Sales</dt>
                                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                                        {{ $customer->sales->count() }}
                                    </dd>
                                </div>

                                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                                    <dt class="truncate text-sm font-medium text-gray-500">Total Amount</dt>
                                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                                        Rp {{ number_format($customer->sales->sum('total_amount'), 0, ',', '.') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Recent Sales --}}
                    <div class="mt-8">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Recent Sales</h3>
                            <a href="{{ route('sales.create', ['customer_id' => $customer->id]) }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                Create New Sale
                            </a>
                        </div>

                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Invoice</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Amount</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse($customer->sales()->latest()->take(5)->get() as $sale)
                                        <tr>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                {{ $sale->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                                {{ $sale->invoice_number }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                                Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                @if ($sale->trashed())
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
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                                <a href="{{ route('sales.show', $sale) }}"
                                                    class="text-blue-600 hover:text-blue-900">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                No sales found for this customer.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button type="button" onclick="window.history.back()">
                            {{ __('Back') }}
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
