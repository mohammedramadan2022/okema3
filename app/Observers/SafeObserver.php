<?php

namespace App\Observers;

use App\Models\Safe;
use Illuminate\Support\Facades\DB;

class SafeObserver
{
    public function created(Safe $safe)
    {
        DB::afterCommit(function () use ($safe) {
            $safe->safeTransactions()->create([
                'value' => $safe->current_balance,
                'safe_id' => $safe->id,
                'effect' => 'deposit',
                'amount' => $safe->current_balance,
                'balance_before' => 0,
                'balance_after' => $safe->current_balance,
                'admin_id' => auth()->guard('admin')->user()->id,
                'safable_type' => Safe::class,
                'safable_id' => $safe->id,
            ]);

        });
    }

}
