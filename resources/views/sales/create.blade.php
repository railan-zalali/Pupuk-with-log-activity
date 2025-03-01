<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Sale') }}
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
                            <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
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

            @push('styles')
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            @endpush

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                            <div>
                                <x-input-label for="invoice_number" value="Invoice Number" />
                                <x-text-input id="invoice_number" name="invoice_number" type="text"
                                    class="mt-1 block w-full bg-gray-100" :value="$invoiceNumber" readonly />
                            </div>

                            <div>
                                <x-input-label for="date" value="Date" />
                                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full"
                                    :value="old('date', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            {{-- <div>
                                <x-input-label for="customer_name" value="Customer Name" />
                                <x-text-input id="customer_name" name="customer_name" type="text"
                                    class="mt-1 block w-full" :value="old('customer_name')" />
                                <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                            </div> --}}

                            <div>
                                <x-input-label for="customer_select" value="Customer Name" />
                                <select id="customer_select" name="customer_id"
                                    class="select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Select Customer or Type New Name --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->nama }} - {{ $customer->nik }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="customer_name" id="new_customer_name">
                                <div class="mt-1 text-xs text-gray-500">Select existing customer or type a new name
                                </div>
                            </div>

                            <div>
                                <x-input-label for="payment_method" value="Payment Method" />
                                <select id="payment_method" name="payment_method"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                    <option value="transfer"
                                        {{ old('payment_method') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                                </select>
                                <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Sale Items</h3>
                                <button type="button" onclick="addItem()"
                                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                    Add Item
                                </button>
                            </div>

                            <div class="mt-4 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Product</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Stock</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Quantity</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Price</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Subtotal</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="saleItems" class="divide-y divide-gray-200 bg-white">
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-right font-medium">Total:</td>
                                            <td id="totalAmount" class="px-6 py-4 font-bold">Rp 0</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-right font-medium">Paid Amount:
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="number" name="paid_amount" id="paid_amount"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    value="0" min="0" onchange="calculateChange()" required>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-right font-medium">Change:</td>
                                            <td id="changeAmount" class="px-6 py-4 font-bold">Rp 0</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <x-secondary-button type="button" onclick="window.history.back()">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Create Sale
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
            function createItemRow() {
                return `
                <tr>
                    <td class="px-6 py-4">
                        <select name="product_id[]" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="updatePrice(this)">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-6 py-4 available-stock">0</td>
                    <td class="px-6 py-4">
                        <input type="number" name="quantity[]" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="1" min="1" onchange="calculateSubtotal(this)">
                    </td>
                    <td class="px-6 py-4">
                        <input type="number" name="selling_price[]" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="0" min="0" onchange="calculateSubtotal(this)" readonly>
                    </td>
                    <td class="px-6 py-4 subtotal">Rp 0</td>
                    <td class="px-6 py-4">
                        <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-900">Remove</button>
                    </td>
                </tr>
            `;
            }

            function updatePrice(select) {
                const tr = select.closest('tr');
                const priceInput = tr.querySelector('input[name="selling_price[]"]');
                const stockDisplay = tr.querySelector('.available-stock');
                const quantityInput = tr.querySelector('input[name="quantity[]"]');
                const selectedOption = select.options[select.selectedIndex];

                if (selectedOption.value) {
                    const price = selectedOption.dataset.price;
                    const stock = selectedOption.dataset.stock;
                    priceInput.value = price || 0;
                    stockDisplay.textContent = stock;
                    quantityInput.max = stock;
                } else {
                    priceInput.value = 0;
                    stockDisplay.textContent = 0;
                    quantityInput.max = 0;
                }

                calculateSubtotal(priceInput);
            }

            function calculateSubtotal(input) {
                const tr = input.closest('tr');
                const quantity = tr.querySelector('input[name="quantity[]"]').value || 0;
                const price = tr.querySelector('input[name="selling_price[]"]').value || 0;
                const subtotal = quantity * price;
                tr.querySelector('.subtotal').textContent = formatRupiah(subtotal);
                calculateTotal();
            }

            function calculateTotal() {
                const subtotals = document.querySelectorAll('.subtotal');
                let total = 0;
                subtotals.forEach(subtotal => {
                    const value = subtotal.textContent.replace('Rp ', '').replace(/\./g, '');
                    total += parseFloat(value) || 0;
                });
                document.getElementById('totalAmount').textContent = formatRupiah(total);
                calculateChange();
            }

            function calculateChange() {
                const totalText = document.getElementById('totalAmount').textContent;
                const total = parseFloat(totalText.replace('Rp ', '').replace(/\./g, '')) || 0;
                const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
                const change = paid - total;
                document.getElementById('changeAmount').textContent = formatRupiah(Math.max(0, change));

                // Validate minimum paid amount
                const submitButton = document.querySelector('button[type="submit"]');
                if (paid < total) {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            function formatRupiah(number) {
                return 'Rp ' + number.toLocaleString('id-ID');
            }

            function addItem() {
                const tbody = document.getElementById('saleItems');
                tbody.insertAdjacentHTML('beforeend', createItemRow());
            }

            function removeItem(button) {
                const tbody = document.getElementById('saleItems');
                if (tbody.children.length > 1) {
                    button.closest('tr').remove();
                    calculateTotal();
                }
            }

            // Form validation before submit
            document.getElementById('saleForm').addEventListener('submit', function(e) {
                const tbody = document.getElementById('saleItems');
                if (tbody.children.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one item');
                    return false;
                }

                const totalText = document.getElementById('totalAmount').textContent;
                const total = parseFloat(totalText.replace('Rp ', '').replace(/\./g, '')) || 0;
                const paid = parseFloat(document.getElementById('paid_amount').value) || 0;

                if (paid < total) {
                    e.preventDefault();
                    alert('Paid amount must be greater than or equal to total amount');
                    return false;
                }

                return true;
            });

            // Add first item on page load
            document.addEventListener('DOMContentLoaded', function() {
                addItem();
            });
            $('#customer_select').select2({
                tags: true,
                createTag: function(params) {
                    return {
                        id: 'new:' + params.term,
                        text: params.term,
                        newTag: true
                    }
                },
                templateResult: function(data) {
                    var $result = $("<span></span>");

                    if (data.newTag) {
                        $result.text(data.text + " (Tambahkan Customer Baru)");
                        $result.addClass("text-blue-600");
                    } else {
                        $result.text(data.text);
                    }

                    return $result;
                }
            });

            // Handle form submission to separate customer_id vs customer_name
            $('#saleForm').on('submit', function() {
                var customerSelect = $('#customer_select');
                var selectedOption = customerSelect.val();

                // If the selected value starts with 'new:', it's a new customer name
                if (selectedOption && selectedOption.startsWith('new:')) {
                    // Extract the name part
                    var newName = selectedOption.substring(4);

                    // Set the new customer name in the hidden input
                    $('#new_customer_name').val(newName);

                    // Reset the customer_id to empty since we're creating a new customer
                    customerSelect.val('');
                }

                return true;

            });
        </script>
    @endpush
</x-app-layout>
