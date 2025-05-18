<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddClientExpenseRequest;
use App\Http\Requests\Admin\AddExpenseRequest;
use App\Http\Requests\Admin\ExpenseRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Safe;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    use Upload_Files, ResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        dd(14);
        if ($request->ajax()) {
            $expenses = Expense::query()->latest()->select(['id', 'name', 'is_active', 'created_at']);
            return Datatables::of($expenses)
                ->addColumn('action', function ($expense) {
                    return '
                    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="'.$expense->id.'">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                            </svg>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" data-id="'.$expense->id.'">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
                            </svg>
                        </span>
                    </button>
                ';
                })
                ->editColumn('is_active', function ($expense) {
                    $active = $expense->is_active == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch">
                           <input class="form-check-input activeBtn" data-id="'.$expense->id.'" type="checkbox" role="switch" id="flexSwitchCheckChecked_'.$expense->id.'" '.$active.'>
                        </div>';
                })
                ->editColumn('created_at', function ($expense) {
                    return date('Y/m/d', strtotime($expense->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.expense.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('Admin.CRUDS.expense.parts.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        DB::beginTransaction();

        try {
            $expense = Expense::create($request->validated());

            DB::commit();
            return $this->addResponse();

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return $this->addResponse('حدث خطأ أثناء حفظ البيانات');
        }
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
    public function edit(Expense $expense)
    {
        return view('Admin.CRUDS.expense.parts.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->validated());

        return $this->addResponse();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }


    public function activate(Request $request)
    {

        $expense = Expense::findOrFail($request->id);
        $expense->is_active == 1 ? $expense->is_active = 0 : $expense->is_active = 1;
        $expense->save();
        return $this->successResponse();
    }

    public function getAddExpenseTransaction(Request $request)
    {
        $expenses = Expense::Active()->get();

        $safes = Safe::Active()->get();

        return view('Admin.CRUDS.expense.add-expense', compact('expenses', 'safes'));

    }

    public function postAddExpenseTransaction(AddExpenseRequest $request)
    {


        DB::beginTransaction();

        try {
            $expense = Expense::findOrFail($request->expense_id);
            $safe = Safe::findOrFail($request->safe_id);


            $transaction = $expense->transactions()->create([
                'amount' => $request->amount,
                'notes' => $request->notes,
                'safe_id' => $request->safe_id,
            ]);

            $lastTransaction = $safe->transactions()->latest()->first();
            $transaction->safesTransaction()->create([
                'amount'         => $transaction->amount,
                'safe_id'         => $safe->id,
                'effect'         => 'debit',
                'balance_before' => $lastTransaction ? $lastTransaction->balance_after : 0,
                'balance_after'  => $lastTransaction ? $lastTransaction->balance_after - $transaction->amount : $transaction->amount,
                'admin_id'       => auth()->guard('admin')->user()->id,
            ]);



            DB::commit();
            return back()->with(['success' => 'Saved successfully']);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return $this->addResponse('حدث خطأ أثناء حفظ البيانات');
        }
    }
    public function getAddClientExpenseTransaction(Request $request)
    {
        $clients = Client::Active()->get();

        $safes = Safe::Active()->get();

        return view('Admin.CRUDS.expense.add-client-expense', compact('clients', 'safes'));

    }

    public function postAddClientExpenseTransaction(AddClientExpenseRequest $request)
    {

        DB::beginTransaction();

        try {
            $client = Client::findOrFail($request->client_id);
            $safe = Safe::findOrFail($request->safe_id);



            $transaction = $client->expenseTransactions()->create([
                'amount' => $request->amount,
                'notes' => $request->notes,
                'safe_id' => $request->safe_id,
                'type' => 2,
            ]);

            $lastTransaction = $safe->transactions()->latest()->first();
            $transaction->safesTransaction()->create([
                'amount'         => $transaction->amount,
                'safe_id'         => $safe->id,
                'effect'         => 'debit',
                'balance_before' => $lastTransaction ? $lastTransaction->balance_after : 0,
                'balance_after'  => $lastTransaction ? $lastTransaction->balance_after - $transaction->amount : $transaction->amount,
                'admin_id'       => auth()->guard('admin')->user()->id,
            ]);



            DB::commit();
            return back()->with(['success' => 'Saved successfully']);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return $this->addResponse('حدث خطأ أثناء حفظ البيانات');
        }
    }


}
