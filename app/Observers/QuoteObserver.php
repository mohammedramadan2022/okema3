<?php
namespace App\Observers;

use App\Models\Client;
use App\Models\Quote;
use App\Models\Store;
use Illuminate\Support\Facades\DB;

class QuoteObserver
{

    public function creating(Quote $quote)
    {
        $quote->created_by = auth()->guard('admin')->user()->id ?? 0;
        $quote->updated_by = auth()->guard('admin')->user()->id ?? 0;
        $lastQuote         = Quote::where('client_id', $quote->client_id)
            ->orderBy(DB::raw('CAST(quote_id AS UNSIGNED)'), 'DESC')
            ->first();
//        $client          = Client::whereId($quote->client_id)->first();
//        $quote->quote_id = $lastQuote ? $lastQuote->quote_id + 1 : ($client ? $client->quote_start : 1);
    }

    public function created($model)
    {

        DB::afterCommit(function () use ($model) {

            $total = 0;
            foreach ($model->items as $item) {
                $total += $item->quantity * $item->price;
            }
            $model->amount = $total;
            $model->final_amount = $total;
            $model->save();

        });
    }
}
