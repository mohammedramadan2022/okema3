<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Client;
use App\Models\ExpenseTransaction;
use App\Models\Invoice;
use App\Models\Safe;
use App\Models\SafesTransaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    use ResponseTrait, Upload_Files;

    public function safesTransactions(Request $request)
    {
        $safes = Safe::get();
        if ($request->ajax()) {
            $transactions = SafesTransaction::query()->when($request->safe, function ($query) use ($request) {

                $query->where('safe_id', $request->safe);
            })->when($request->from_date, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->from_date);

            })->when($request->to_date, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->to_date);

            })->latest()->with('safe');
            return Datatables::of($transactions)
                ->editColumn('created_at', function ($safe) {
                    return date('Y/m/d', strtotime($safe->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.reports.safes-transactions', compact('safes'));

    }

    public function deservedInvoices(Request $request)
    {
        $clients = Client::get();

        if ($request->ajax()) {
            $invoices = Invoice::where('status' , 1)->latest()->with('client')->withSum('safesTransaction' , 'amount');


        //   dd($invoices->get());
            return Datatables::of($invoices)
                ->editColumn('created_at', function ($invoice) {
                    return date('Y/m/d', strtotime($invoice->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.reports.deserved-invoices', compact('clients'));



    }



    public function generalExpenseTransactions(Request $request)
    {
        $safes = Safe::get();
        if ($request->ajax()) {
            $transactions = ExpenseTransaction::where('type', 1)->when($request->safe, function ($query) use ($request) {

                $query->where('safe_id', $request->safe);
            })->when($request->from_date, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->from_date);

            })->when($request->to_date, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->to_date);

            })->latest()->with( 'safesTransaction.safe')->with('expense');
            return Datatables::of($transactions)
                ->editColumn('created_at', function ($safe) {
                    return date('Y/m/d', strtotime($safe->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.reports.general-expense-transactions', compact('safes'));



    }
    public function clientExpenseTransactions(Request $request)
    {
        $safes = Safe::get();
        $clients = Client::get();
        if ($request->ajax()) {
            $transactions = ExpenseTransaction::where('type', 2)->when($request->safe_id, function ($query) use ($request) {

                $query->where('safe_id', $request->safe_id);
            })->when($request->client_id, function ($query) use ($request) {

                $query->where('client_id', $request->client_id);
            })->when($request->from_date, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->from_date);

            })->when($request->to_date, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->to_date);

            })->latest()->with( 'safesTransaction.safe')->with('client');
            return Datatables::of($transactions)
                ->editColumn('created_at', function ($safe) {
                    return date('Y/m/d', strtotime($safe->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.reports.client-expense-transactions', compact('safes' , 'clients'));



    }
}
