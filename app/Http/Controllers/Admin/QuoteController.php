<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuoteRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Client;
use App\Models\Clientss;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Invoiceitemss;
use App\Models\Invoicess;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Quote_itemss;
use App\Models\QuoteItem;
use App\Models\Quotess;
use App\Models\Store;
use App\Models\Userss;
use App\Repositories\QuoteRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class QuoteController extends Controller
{
    use Upload_Files, ResponseTrait;

    public $quoteRepository;

    public function __construct(QuoteRepository $quoteRepo)
    {
        $this->quoteRepository = $quoteRepo;
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $quotes = Quote::where('type' , 1)->when($request->search , function ($query) use ($request){
                $query->where('location' , 'like', '%' . $request->search . '%');
                $query->orWhere('shop_name' , 'like', '%' . $request->search . '%');
                $query->orWhereHas('items' , function ($q) use ($request){
                    $q->where('quote_items.product_name' ,'like', '%' . $request->search . '%' );

                });

            })->latest()->with('items', 'client');
            return DataTables::of($quotes)
                ->addColumn('action', function ($quote) {
                    return view('Admin.quotes.parts.actions', compact('quote'))->render();
                })
                ->editColumn('created_at', function ($quote) {
                    return date('Y/m/d', strtotime($quote->created_at));
                })
                ->escapeColumns([])
                ->make(true);

        }

        return view('Admin.quotes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $clients = Client::where('is_active', 1)->get();
        $products = Product::where('is_active', 1)->get();
        $stores = Store::where('is_active', 1)->get();
        $statusArr = Quote::STATUS_ARR;

        return view('Admin.quotes.create', compact('clients', 'stores', 'products' ,'statusArr'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuoteRequest $request)
    {
//        dd($request->all());

        try {
            DB::beginTransaction();
            $quote = Quote::create([
                'client_id'  => $request->client_id,
                'quote_id'   => $request->quote_id,
                'quote_date' => $request->quote_date,
                'due_date'   => $request->due_date,
//                'status'     => $request->status,
                'shop_name'  => $request->shop_name,
                'location'   => $request->location,
                'type'       => 1,
                'term'       => $request->term,
                'note'       => $request->note,

            ]);

            foreach ($request->product_id as $key => $productId) {
                $item = $quote->items()->create([
                    'product_id' => $request->item_type[$key] == 'stock' ?  $productId : null,
                    'product_name' => $request->item_type[$key] == 'non_stock' ?  $productId : null,
                    'quantity' => $request->quantity[$key],
                    'price' => $request->price[$key],
                    'unit' => $request->unit[$key],
                    'total' => $request->price[$key] * $request->quantity[$key],

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
//
        } catch (\Exception $e) {
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


    public function getLastQuoteId(Request $request)
    {


        $clientId = $request->input('client_id');


        $client = Client::whereId($clientId)->first();
        $lastQuote = Quote::where('client_id', $client->id)
            ->orderBy(DB::raw('CAST(quote_id AS UNSIGNED)'), 'DESC')
            ->first();
        return response()->json([
            'last_quote_id' => $lastQuote && $lastQuote->quote_id + 1 > $client->quote_start   ? $lastQuote->quote_id + 1 : ($client ? $client->quote_start : 1),
        ]);
    }


    public function convertToPdf(Quote $quote)
    {
        $quoteData = $this->quoteRepository->getPdfData($quote);
        $html = view('Admin.Pdf.quote_template_pdf', compact('quoteData'))->render();

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

        return $pdf->stream('quotation.pdf');
    }

    public function getClients()
    {

        $invoices = Invoicess::take(50)->get();

        foreach ($invoices as $invoice) {
            if ($invoice->invoice_id != null) {


                $newInvoice = Invoice::create([
                    'id' => $invoice->id,
                    'invoice_id' => 11,
                    'client_id' => $invoice->client_id,
                    'invoice_date' => $invoice->invoice_date,
                    'due_date' => $invoice->due_date,
                    'amount' => $invoice->amount,
                    'final_amount' => $invoice->final_amount,
                    'discount_type' => $invoice->discount_type,
                    'discount' => $invoice->discount,
                    'note' => $invoice->note,
                    'term' => $invoice->term,
                    'recurring' => $invoice->recurring,
                    'status' => $invoice->status,
                    'shop_name' => $invoice->shop_name,
                    'location' => $invoice->location,
                    'type' => 0,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => 1,
                ]);
                $items = Invoiceitemss::where('invoice_id', $invoice->id)->get();
                foreach ($items as $item) {
                    InvoiceItem::create([
                        'id' => $item->id,
                        'invoice_id' => $newInvoice->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'total' => $item->total,
                    ]);
                }


                $invoice->delete();
            }

        }


        return 'done';

    }


    public function convertToInvoice(Request $request, $quoteId)
    {
        try {
            DB::beginTransaction();
            $quote = Quote::findOrFail($quoteId);
            $laseInvoiceId = self::getLastInvoiceId($quote->client_id);

            $invoice = Invoice::create([
                'client_id' => $quote->client_id,
                'invoice_id' => $laseInvoiceId,
                'invoice_date' => $quote->quote_date,
                'due_date' => $quote->due_date,
                'status' => $quote->status,
                'shop_name' => $quote->shop_name,
                'location' => $quote->location,
                'type' => 1,
            ]);
            foreach ($quote->items as $item) {
                $invoice->items()->create([
                    'product_name' => $item->product_name,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'unit' => $item->unit,
                    'total' => $item->total,
                    'image' => $item->image,
                ]);
            }
            DB::commit();
            $quote->status = 1;
            $quote->save();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return redirect()->back()->with('success', 'Converted successfully');

    }


    public static function getLastInvoiceId($clientId, $skip = 0)
    {
        // Get the client
        $client = Client::whereId($clientId)->first();

        // Get the last invoice by skipping the number of records indicated by $skip
        $lastInvoice = Invoice::where('client_id', $clientId)
            ->latest('invoice_id')
            ->skip($skip)
            ->first();


        // If there is no invoice, return the client's invoice start or 1
        if (!$lastInvoice) {
            return $client ? $client->invoice_start : 1;
        }
        return $lastInvoice ? $lastInvoice->invoice_id + 1 : 1;


        // Extract the numerical part of the invoice ID
        if (preg_match('/(\d+)$/', $lastInvoice->invoice_id, $matches)) {
            // If a valid number is found, return the incremented invoice ID
            return self::getLastIvoicePlus1($lastInvoice->invoice_id);
        }

        // If no match is found, increment $skip and recursively call the function
        return self::getLastInvoiceId($clientId, $skip + 1);
    }
}
