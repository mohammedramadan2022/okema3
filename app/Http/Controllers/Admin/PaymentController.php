<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Safe;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     use Upload_Files, ResponseTrait;
     public function index()
    {
        $invoices = Invoice::where('amount', '>', function ($query) {
            $query->selectRaw('SUM(safes_transactions.amount)')
                ->from('safes_transactions')
                ->whereColumn('safes_transactions.safable_id', 'invoices.id')
                ->where('safes_transactions.safable_type', Invoice::class);
        })
            ->orderBy('created_at', 'desc')
            ->pluck('invoice_id', 'id')
            ->toArray();

        return view('payments.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('is_active', 1)->get();
        $safes   = Safe::where('is_active', 1)->get();

        return view('Admin.payments.create', compact('clients', 'safes'));
    }

    /**
     * Get unpaid invoices for a specific client
     */
    public function getClientInvoices(Request $request)
    {
        $clientId = $request->client_id;

        $invoices = Invoice::select('id', 'invoice_id', 'final_amount')
            ->where('client_id', $clientId)
            ->where('final_amount', '>', function ($query) {
                $query->selectRaw('COALESCE(SUM(safes_transactions.amount), 0)')
                    ->from('safes_transactions')
                    ->whereColumn('safes_transactions.safable_id', 'invoices.id')
                    ->where('safes_transactions.safable_type', Invoice::class);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($invoice) {
                $totalPayments = $invoice->safesTransaction()->sum('amount');
                return [
                    'id'               => $invoice->id,
                    'invoice_id'       => $invoice->invoice_id,
                    'final_amount'     => $invoice->final_amount,
                    'total_payments'   => $totalPayments,
                    'remaining_amount' => $invoice->final_amount - $totalPayments,
                ];
            });

        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {

        $invoice = Invoice::findOrFail($request->invoice_id);
        $safe    = Safe::findOrFail($request->safe_id);

        $lastTransaction = $safe->transactions()->latest()->first();
        $invoice->safesTransaction()->create([
            'amount'         => $request->paid_amount,
            'safe_id'         => $safe->id,
            'effect'         => 'deposit',
            'balance_before' => $lastTransaction ? $lastTransaction->balance_after : 0,
            'balance_after'  => $lastTransaction ? $lastTransaction->balance_after + $request->paid_amount : $request->paid_amount,
            'admin_id'       => auth()->guard('admin')->user()->id,
        ]);


        $totalPaid = $safe->transactions()
            ->sum('amount');

        if ($totalPaid >= $invoice->final_amount) {
            $invoice->update(['status' => 2]);
        } else {
            $invoice->update(['status' => 1]);
        }
        return  back()->with(['success'=>'Paid Successfully']);


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
