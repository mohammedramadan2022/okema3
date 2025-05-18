<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\purchase\StorePurchaseInvoiceRequest;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $purchases = PurchaseInvoice::query()->latest()->with('supplier', 'store');
            return DataTables::of($purchases)
                ->addColumn('action', function ($admin) {

                    $edit = '';
                    // $delete = '';





                })






                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }


        return view('Admin.purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products  = Product::where('is_active', 1)->get();
        $stores    = Store::where('is_active', 1)->get();
        $suppliers = Supplier::where('is_active', 1)->get();

        return view('Admin.purchase.create', compact('products', 'stores', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseInvoiceRequest $request)
    {
          try {
            DB::beginTransaction();

            $invoice = PurchaseInvoice::create($request->Validated());

            foreach ($request->product_id as $key => $product_id) {
                $invoice->details()->create([
                    'product_id' => $product_id,
                    'quantity'   => $request->quantity[$key],
                    'price'      => $request->price[$key],
                ]);
            }
            DB::commit();

        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return redirect()->back()->with('success', 'Purchase invoice created successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
