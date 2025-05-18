<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenanceQuoteRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Client;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MaintenanceQuoteController extends Controller
{
    use Upload_Files, ResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $quotes = Quote::where('type' , 0)->when($request->search , function ($query) use ($request){
                $query->where('location' , 'like', '%' . $request->search . '%');
                $query->orWhere('shop_name' , 'like', '%' . $request->search . '%');
                $query->orWhereHas('items' , function ($q) use ($request){
                    $q->where('quote_items.product_name' ,'like', '%' . $request->search . '%' );

                });
                $query->orWhereHas('client' , function ($q) use ($request){
                    $q->where('clients.name' ,'like', '%' . $request->search . '%' );
                    $q->orWhere('clients.company_name' ,'like', '%' . $request->search . '%' );
                    $q->orWhere('clients.attention' ,'like', '%' . $request->search . '%' );

                });

            })->latest()->with('items', 'client');
            return DataTables::of($quotes)
            ->addColumn('action', function ($quote) {
                return view('Admin.maintenanceQuotes.parts.actions', compact('quote'))->render();
            })

                ->editColumn('created_at', function ($quote) {
                    return date('Y/m/d', strtotime($quote->created_at));
                })
                ->escapeColumns([])
                ->make(true);

        }

        return view('Admin.maintenanceQuotes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clients = Client::where('is_active', 1)->get();

        $statusArr = Quote::STATUS_ARR;
        $status    = $request->status;

        return view('Admin.maintenanceQuotes.create', compact('clients', 'statusArr', 'status'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(MaintenanceQuoteRequest $request)
    {
        try {
            DB::beginTransaction();
            $quote = Quote::create([
                'client_id'  => $request->client_id,
                'quote_id'   => $request->quote_id,
                'quote_date' => $request->quote_date,
                'due_date'   => $request->due_date,
                'status'     => $request->status,
                'shop_name'  => $request->shop_name,
                'location'   => $request->location,
                'term'       => $request->term,
                'note'       => $request->note,

            ]);

            foreach ($request->product_name as $key => $product_name) {
                $item = $quote->items()->create([
                    'product_name' => $product_name,
                    'notes' => $request->notes[$key],
                    'quantity'     => $request->quantity[$key],
                    'price'        => $request->price[$key],
                    'unit'        => $request->unit[$key],
                    'total'        => $request->price[$key] * $request->quantity[$key],

                ]);


                $files = $request->file('images');
                if (is_array($files) && array_key_exists($key, $files)) {
                    $file = $files[$key];
                    $image = $this->uploadFiles('quotes/' . $quote->id, $file, null);

                    $item->update([
                        'image' => $image,
                    ]);
                }


            }

            DB::commit();

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->back()->with('success', 'Quote  created successfully');

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
    public function edit(Request $request ,string $id)
    {
       $quote = Quote::with('items')->find($id);
        $clients = Client::where('is_active', 1)->get();

        $statusArr = Quote::STATUS_ARR;
        $status    = $request->status;
       return view('Admin.maintenanceQuotes.edit', compact('quote' , 'clients' , 'statusArr' , 'status'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $quote = Quote::findOrFail($id);

            // Update quote details
            $quote->update([
                'client_id' => $request->quote_client_id,
                'quote_id' => $request->quote_id,
                'quote_date' => $request->quote_date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'shop_name' => $request->shop_name,
                'location' => $request->location,
                'term' => $request->term ? $request->term : null,
                'notes' => $request->notes ? $request->notes : null,
            ]);

            // Handle quote items
            if ($request->has('product_name')) {
                // Delete existing items
                $quote->items()->delete();

                // Create new items
                foreach ($request->product_name as $key => $productName) {
                    $item = $quote->items()->create([
                        'product_name' => $productName,
                        'quantity' => $request->quantity[$key],
                        'price' => $request->price[$key],
                        'total' => $request->quantity[$key] * $request->price[$key],
                    ]);

                    // Handle image upload if exists
                    if ($request->hasFile('images') && isset($request->file('images')[$key])) {
                        $file = $request->file('images')[$key];
                        $image = $this->uploadFiles('quotes/' . $quote->id, $file, null);
                        $item->update(['image' => $image]);
                    }
                }
            }

            // Update total amounts
            $totalAmount = $quote->items()->sum(DB::raw('quantity * price'));
            $quote->update([
                'amount' => $totalAmount,
                'final_amount' => $totalAmount,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Quote  Updated successfully');
            } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quote = Quote::findOrFail($id);
        $quoteItems = $quote->items;
        $quote->delete();
        $quoteItems->each->delete();
        return $this->addResponse('Quote deleted successfully');
    }
}
