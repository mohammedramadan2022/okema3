<?php
namespace App\Providers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceDetail;
use App\Models\Quote;
use App\Models\Safe;
use App\Observers\InvoiceObserver;
use App\Observers\ProductObserver;
use App\Observers\PurchaseInvoiceDetailsObserver;
use App\Observers\PurchaseInvoiceObserver;
use App\Observers\QuoteObserver;
use App\Observers\SafeObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(125);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PurchaseInvoice::observe(PurchaseInvoiceObserver::class);
        PurchaseInvoiceDetail::observe(PurchaseInvoiceDetailsObserver::class);
        Product::observe(ProductObserver::class);
        Quote::observe(QuoteObserver::class);
        Invoice::observe(InvoiceObserver::class);
        Safe::observe(SafeObserver::class);
    }
}
