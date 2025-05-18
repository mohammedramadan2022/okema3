<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenanceInvoiceRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MaintenanceInvoiceController extends Controller
{
    use Upload_Files, ResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::query()->where('type' , 0)->when($request->search , function ($query) use ($request){
                $query->where('location' , 'like', '%' . $request->search . '%');
                $query->orWhere('shop_name' , 'like', '%' . $request->search . '%');
                $query->orWhereHas('items' , function ($q) use ($request){
                    $q->where('invoice_items.product_name' ,'like', '%' . $request->search . '%' );

                });
                $query->orWhereHas('client' , function ($q) use ($request){
                    $q->where('client.name' ,'like', '%' . $request->search . '%' );
                    $q->orWhere('client.company_name' ,'like', '%' . $request->search . '%' );
                    $q->orWhere('client.attention' ,'like', '%' . $request->search . '%' );

                });

            })->latest()->with('items', 'client');
            return DataTables::of($invoices)
            ->addColumn('action', function ($invoice) {
                return view('Admin.maintenanceInvoices.parts.actions', compact('invoice'))->render();
            })

                ->editColumn('created_at', function ($invoice) {
                    return date('Y/m/d', strtotime($invoice->created_at));
                })
                ->escapeColumns([])
                ->make(true);

        }

        return view('Admin.maintenanceInvoices.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clients = Client::where('is_active', 1)->get();

        $statusArr = Invoice::STATUS_ARR;
        $status    = $request->status;

        return view('Admin.maintenanceInvoices.create', compact('clients', 'statusArr', 'status'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(MaintenanceInvoiceRequest $request)
    {

        $request['status'] = 1;

        try {
            DB::beginTransaction();
            $invoice = Invoice::create([
                'client_id'    => $request->client_id,
                'invoice_id'   => $request->invoice_id,
                'invoice_date' => $request->invoice_date,
                'due_date'     => $request->due_date,
                'status'       => $request->status,
                'shop_name'    => $request->shop_name,
                'location'     => $request->location,
                'term'         => $request->term,
                'note'         => $request->note,

            ]);

            foreach ($request->product_name as $key => $product_name) {
                $item = $invoice->items()->create([
                    'product_name' => $product_name,
                    'quantity'     => $request->quantity[$key],
                    'price'        => $request->price[$key],
                    'unit'        => $request->unit[$key],
                    'total'        => $request->price[$key] * $request->quantity[$key],

                ]);
                $files = $request->file('images');
                if (is_array($files) && array_key_exists($key, $files)) {
                    $file = $files[$key];
                    $image = $this->uploadFiles('invoices/' . $invoice->id, $file, null);

                    $item->update([
                        'image' => $image,
                    ]);
                }

            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->back()->with('success', 'Invoice  created successfully');

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
