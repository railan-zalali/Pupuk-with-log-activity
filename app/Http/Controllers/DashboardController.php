<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk cards
        $data['totalProducts'] = Product::count();
        $data['totalSalesToday'] = Sale::whereDate('created_at', Carbon::today())->sum('total_amount');
        $data['totalSalesThisMonth'] = Sale::whereMonth('created_at', Carbon::now()->month)->sum('total_amount');
        $data['lowStockProducts'] = Product::whereColumn('stock', '<=', 'min_stock')->count();

        // Data untuk tabel
        $data['lowStockAlerts'] = Product::whereColumn('stock', '<=', 'min_stock')
            ->latest()
            ->limit(5)
            ->get();

        $data['recentTransactions'] = Sale::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Data untuk grafik - Menggunakan pendekatan yang lebih sederhana
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $amount = Sale::whereDate('created_at', $date)->sum('total_amount');

            $dates->push([
                'date' => $date->format('Y-m-d'),
                'total' => $amount
            ]);
        }
        $data['dailySales'] = $dates;

        // Data untuk produk terlaris - Pendekatan lebih sederhana
        $products = Product::all();
        $productsWithSales = $products->map(function ($product) {
            $totalSold = $product->saleDetails()
                ->whereHas('sale', function ($query) {
                    $query->whereNull('deleted_at');
                })
                ->sum('quantity');

            return [
                'name' => $product->name,
                'total_sold' => $totalSold
            ];
        })->sortByDesc('total_sold')
            ->take(5)
            ->values();

        $data['topProducts'] = $productsWithSales;

        return view('dashboard', $data);
    }
}
