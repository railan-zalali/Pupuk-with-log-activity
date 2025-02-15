<?php

namespace App\Http\Controllers;

use App\Imports\CustomersImport;
use App\Models\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = Customer::withCount(['sales' => function ($query) {
                $query->whereNull('deleted_at');
            }]);

            return DataTables::of($customers)
                ->addColumn('action', function ($customer) {
                    $buttons = '<a href="' . route('customers.show', $customer) . '" class="text-blue-600 hover:text-blue-900">View</a>';
                    $buttons .= '<a href="' . route('customers.edit', $customer) . '" class="ml-2 text-indigo-600 hover:text-indigo-900">Edit</a>';

                    if ($customer->sales_count === 0) {
                        $buttons .= '<form action="' . route('customers.destroy', $customer) . '" method="POST" class="inline">'
                            . csrf_field()
                            . method_field('DELETE')
                            . '<button type="submit" class="ml-2 text-red-600 hover:text-red-900" onclick="return confirm(\'Are you sure you want to delete this customer?\')">'
                            . 'Delete</button></form>';
                    }

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('customers.index');
    }


    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|unique:customers,nik',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'provinsi_id' => 'required|string',
            'kabupaten_id' => 'required|string',
            'kecamatan_id' => 'required|string',
            'desa_id' => 'required|string',
            'provinsi_nama' => 'required|string',
            'kabupaten_nama' => 'required|string',
            'kecamatan_nama' => 'required|string',
            'desa_nama' => 'required|string',
        ]);

        Customer::create($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer created successfully');
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'nik' => 'required|string|unique:customers,nik,' . $customer->id,
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'provinsi_id' => 'required|string',
            'kabupaten_id' => 'required|string',
            'kecamatan_id' => 'required|string',
            'desa_id' => 'required|string',
            'provinsi_nama' => 'required|string',
            'kabupaten_nama' => 'required|string',
            'kecamatan_nama' => 'required|string',
            'desa_nama' => 'required|string',
        ]);

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated successfully');
    }

    public function show(Customer $customer)
    {
        $customer->load(['sales' => function ($query) {
            $query->latest();
        }]);

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function destroy(Customer $customer)
    {
        if ($customer->sales()->exists()) {
            return back()->with('error', 'Cannot delete customer with sales history');
        }

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully');
    }

    // API untuk select2
    public function search(Request $request)
    {
        $term = $request->get('term');

        $customers = Customer::where('nama', 'like', "%{$term}%")
            ->orWhere('nik', 'like', "%{$term}%")
            ->limit(10)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'text' => "$customer->nama - $customer->nik"
                ];
            });

        return response()->json(['results' => $customers]);
    }
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new CustomersImport, $request->file('excel_file'));

        return redirect()->back()->with('success', 'Data pelanggan berhasil diimpor!');
    }
}
