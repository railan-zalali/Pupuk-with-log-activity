<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function index()
    {
        $sales = Sale::with(['user', 'customer'])
            ->latest()
            ->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        $customers = Customer::orderBy('nama')->get();

        // Generate invoice number
        $lastSale = Sale::whereDate('created_at', Carbon::today())->latest()->first();
        $lastNumber = $lastSale ? intval(substr($lastSale->invoice_number, -4)) : 0;
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return view('sales.create', compact('products', 'customers', 'invoiceNumber'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'invoice_number' => 'required|unique:sales',
    //         'customer_id' => 'nullable|exists:customers,id',
    //         'product_id' => 'required|array',
    //         'product_id.*' => 'exists:products,id',
    //         'quantity' => 'required|array',
    //         'quantity.*' => 'integer|min:1',
    //         'selling_price' => 'required|array',
    //         'selling_price.*' => 'numeric|min:0',
    //         'paid_amount' => 'required|numeric|min:0',
    //         'payment_method' => 'required|in:cash,transfer',
    //         'notes' => 'nullable|string'
    //     ]);

    //     // Validasi stok
    //     foreach ($request->product_id as $key => $productId) {
    //         $product = Product::find($productId);
    //         if ($product->stock < $request->quantity[$key]) {
    //             return back()->with('error', "Stok tidak cukup untuk produk: {$product->name}");
    //         }
    //     }

    //     // Hitung total
    //     $totalAmount = collect($request->product_id)->map(function ($item, $key) use ($request) {
    //         return $request->quantity[$key] * $request->selling_price[$key];
    //     })->sum();

    //     // Validasi pembayaran
    //     if ($request->paid_amount < $totalAmount) {
    //         return back()->with('error', 'Pembayaran kurang dari total belanja');
    //     }

    //     try {
    //         $sale = Sale::create([
    //             'invoice_number' => $request->invoice_number,
    //             'customer_id' => $request->customer_id,
    //             'user_id' => auth()->id(),
    //             'date' => now(), // Gunakan Carbon untuk date
    //             'total_amount' => $totalAmount,
    //             'paid_amount' => $request->paid_amount,
    //             'change_amount' => $request->paid_amount - $totalAmount,
    //             'payment_method' => $request->payment_method,
    //             'notes' => $request->notes
    //         ]);

    //         // Simpan detail dan update stok
    //         foreach ($request->product_id as $key => $productId) {
    //             $quantity = $request->quantity[$key];
    //             $price = $request->selling_price[$key];

    //             // Simpan detail
    //             $sale->saleDetails()->create([
    //                 'product_id' => $productId,
    //                 'quantity' => $quantity,
    //                 'selling_price' => $price,
    //                 'subtotal' => $quantity * $price
    //             ]);

    //             // Update stok
    //             $products = Product::find($request->product_id);
    //             $beforeStock = $product->stock;
    //             $product->stock -= $quantity;
    //             $product->save();

    //             // Catat pergerakan stok
    //             $product->stockMovements()->create([
    //                 'type' => 'out',
    //                 'quantity' => $quantity,
    //                 'before_stock' => $beforeStock,
    //                 'after_stock' => $product->stock,
    //                 'reference_type' => 'sale',
    //                 'reference_id' => $sale->id,
    //                 'notes' => 'Penjualan produk'
    //             ]);
    //         }

    //         return redirect()
    //             ->route('sales.show', $sale)
    //             ->with('success', 'Transaksi berhasil');
    //     } catch (\Exception $e) {
    //         return back()
    //             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|unique:sales',
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string|max:255',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'selling_price' => 'required|array',
            'selling_price.*' => 'numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer',
            'notes' => 'nullable|string'
        ]);

        // Validasi stok
        foreach ($request->product_id as $key => $productId) {
            $product = Product::find($productId);
            if ($product->stock < $request->quantity[$key]) {
                return back()->with('error', "Stok tidak cukup untuk produk: {$product->name}");
            }
        }

        // Hitung total
        $totalAmount = collect($request->product_id)->map(function ($item, $key) use ($request) {
            return $request->quantity[$key] * $request->selling_price[$key];
        })->sum();

        // Validasi pembayaran
        if ($request->paid_amount < $totalAmount) {
            return back()->with('error', 'Pembayaran kurang dari total belanja');
        }

        // Handle customer baru jika diisi
        $customerId = $request->customer_id;
        if (empty($customerId) && !empty($request->customer_name)) {
            // Buat customer baru
            $customer = Customer::create([
                'nama' => $request->customer_name,
                'nik' => 'TEMP-' . time(), // NIK sementara, bisa diupdate nanti
                'desa_id' => '0',
                'kecamatan_id' => '0',
                'kabupaten_id' => '0',
                'provinsi_id' => '0',
                'desa_nama' => '-',
                'kecamatan_nama' => '-',
                'kabupaten_nama' => '-',
                'provinsi_nama' => '-'
            ]);
            $customerId = $customer->id;
        }

        try {
            $sale = Sale::create([
                'invoice_number' => $request->invoice_number,
                'customer_id' => $customerId,
                'user_id' => auth()->id(),
                'date' => now(), // Gunakan Carbon untuk date
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->paid_amount - $totalAmount,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes
            ]);

            // Simpan detail dan update stok
            foreach ($request->product_id as $key => $productId) {
                $quantity = $request->quantity[$key];
                $price = $request->selling_price[$key];
                $product = Product::find($productId);

                // Simpan detail
                $sale->saleDetails()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'selling_price' => $price,
                    'subtotal' => $quantity * $price
                ]);

                // Update stok
                $beforeStock = $product->stock;
                $product->stock -= $quantity;
                $product->save();

                // Catat pergerakan stok
                $product->stockMovements()->create([
                    'type' => 'out',
                    'quantity' => $quantity,
                    'before_stock' => $beforeStock,
                    'after_stock' => $product->stock,
                    'reference_type' => 'sale',
                    'reference_id' => $sale->id,
                    'notes' => 'Penjualan produk'
                ]);
            }

            return redirect()
                ->route('sales.show', $sale)
                ->with('success', 'Transaksi berhasil');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function show(Sale $sale)
    {
        $sale->load(['saleDetails.product', 'user', 'customer']);
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        // Eager load saleDetails dan product terkait untuk menghindari N+1 Query
        $sale->load(['saleDetails.product']);

        // Kembalikan stok untuk setiap detail penjualan
        foreach ($sale->saleDetails as $detail) {
            $product = $detail->product;
            $beforeStock = $product->stock;

            // Kembalikan stok yang terjual
            $product->increment('stock', $detail->quantity);

            // Catat pergerakan stok
            $product->stockMovements()->create([
                'type' => 'in',
                'quantity' => $detail->quantity,
                'before_stock' => $beforeStock,
                'after_stock' => $product->stock,
                'reference_type' => 'sale_void',
                'reference_id' => $sale->id,
                'notes' => 'Sale void'
            ]);
        }

        // Hapus penjualan setelah mengembalikan stok
        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale voided successfully');
    }

    // API untuk mendapatkan product details
    public function getProduct(Product $product)
    {
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'selling_price' => $product->selling_price,
            'stock' => $product->stock
        ]);
    }
    public function invoice(Sale $sale)
    {
        $sale->load(['saleDetails.product', 'user']);
        return view('sales.invoice', compact('sale'));
    }
}
