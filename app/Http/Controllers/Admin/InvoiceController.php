<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvoiceRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Store;
use App\Repositories\InvoiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{

    use Upload_Files, ResponseTrait;

    public $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepo)
    {
        $this->invoiceRepository = $invoiceRepo;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $purchases = Invoice::query()->when($request->search ,  function ($query) use($request) {
                $query->whereHas('client', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })->orWhere('invoice_id', 'like', '%' . $request->search . '%')->orWhereHas('items', function ($q) use ($request) {
                    $q->where('product_name', 'like', '%' . $request->search . '%');
                    $q->orWhere('code', 'like', '%' . $request->search . '%');
                });


            })->where('type', 1)
                ->latest()->with('client');
            return DataTables::of($purchases)
                ->addColumn('action', function ($invoice) {
                    return view('Admin.invoices.parts.actions', compact('invoice'))->render();
                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }

        return view('Admin.invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clients = Client::where('is_active', 1)->get();
        $products = Product::where('is_active', 1)->get();
        $stores = Store::where('is_active', 1)->get();

        $statusArr = Invoice::STATUS_ARR;
        $status = $request->status;
        return view('Admin.invoices.create', compact('clients', 'statusArr', 'status', 'products', 'stores'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $request['status'] = 1;
        try {
            DB::beginTransaction();
            $invoice = Invoice::create([
                'client_id' => $request->client_id,
                'invoice_id' => $request->invoice_id,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'type' => 1,
                'term' => $request->term,
                'note' => $request->note,

            ]);

            foreach ($request->product_id as $key => $productId) {
                $item = $invoice->items()->create([
                    'product_id' => $request->item_type[$key] == 'stock' ? $productId : null,
                    'product_name' => $request->item_type[$key] == 'non_stock' ? $productId : null,
                    'quantity' => $request->quantity[$key],
                    'unit' => $request->unit[$key],
                    'price' => $request->price[$key],
                    'total' => $request->price[$key] * $request->quantity[$key],
                    'code' => $request->code[$key],

                ]);
                $files = $request->file('images');
                if (is_array($files) && array_key_exists($key, $files)) {
                    $file = $files[$key];
                    $image = $this->uploadFiles('invoices/'.$invoice->id, $file, null);

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


    public function convertToPdf(Invoice $invoice)
    {

        $invoiceData = $this->invoiceRepository->getPdfData($invoice);
        $html = view('Admin.Pdf.invoice_template_pdf', compact('invoiceData'))->render();

        $pdf = Pdf::setOptions([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'isPhpEnabled' => true,
            'enable_css_float' => true,
            'enable_javascript' => true,
        ]);

        $pdf->loadHTML($html);

        return $pdf->stream('invoice.pdf');
    }

    public function getLastInvoiceId(Request $request)
    {


        $clientId = $request->input('client_id');


        $client = Client::whereId($clientId)->first();
        $lastInvoice = Invoice::where('client_id', $client->id)
            ->orderBy(DB::raw('CAST(invoice_id AS UNSIGNED)'), 'DESC')
            ->first();
        return response()->json([
            'last_invoice_id' => $lastInvoice && $lastInvoice->invoice_id + 1 > $client->invoice_start ? $lastInvoice->invoice_id + 1 : ($client ? $client->invoice_start : 1),
        ]);
    }

}
