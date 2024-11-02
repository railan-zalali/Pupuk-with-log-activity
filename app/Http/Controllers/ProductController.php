<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        // Generate kode produk
        $lastProduct = Product::whereDate('created_at', Carbon::today())->latest()->first();
        $lastNumber = $lastProduct ? intval(substr($lastProduct->code, -4)) : 0;
        $productCode = 'PRD-' . date('Ymd') . '-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return view('products.create', compact('categories', 'productCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0'
        ]);

        $product = Product::create($validated);

        // Record initial stock movement
        $initialStock = $validated['stock'];
        if ($initialStock > 0) {
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $initialStock,
                'before_stock' => 0,
                'after_stock' => $initialStock,
                'reference_type' => 'initial',
                'reference_id' => $product->id,
                'notes' => 'Initial stock'
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'stockMovements' => function ($query) {
            $query->latest();
        }]);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products,code,' . $product->id,
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'min_stock' => 'required|integer|min:0'
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'adjustment_type' => 'required|in:add,subtract',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $beforeStock = $product->stock;
        $quantity = $validated['quantity'];

        if ($validated['adjustment_type'] === 'add') {
            $product->increment('stock', $quantity);
            $type = 'in';
        } else {
            if ($product->stock < $quantity) {
                return back()->with('error', 'Insufficient stock');
            }
            $product->decrement('stock', $quantity);
            $type = 'out';
        }

        // Record stock movement
        StockMovement::create([
            'product_id' => $product->id,
            'type' => $type,
            'quantity' => $quantity,
            'before_stock' => $beforeStock,
            'after_stock' => $product->stock,
            'reference_type' => 'adjustment',
            'reference_id' => $product->id,
            'notes' => $validated['notes'] ?? null
        ]);

        return back()->with('success', 'Stock updated successfully');
    }
}
