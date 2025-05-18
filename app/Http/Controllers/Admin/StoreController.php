<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStore;
use Yajra\DataTables\DataTables;

class StoreController extends Controller
{

    use Upload_Files, ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stores = Store::query()->latest()->select(['id', 'name', 'is_active', 'created_at']);
            return Datatables::of($stores)
                ->addColumn('action', function ($store) {
                    return '
                    <a href="'.route('stores.products', $store->id).'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="View Products">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-264-83T40-500q54-137 172-220t268-83q146 0 264 83t172 220q-54 137-172 220t-268 83Z"/>
                            </svg>
                        </span>
                    </a>
                    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="'.$store->id.'">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                            </svg>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" data-id="'.$store->id.'">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
                            </svg>
                        </span>
                    </button>
                ';
                })
                ->editColumn('is_active', function ($store) {
                    $active = $store->is_active == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch">
                           <input class="form-check-input activeBtn" data-id="'.$store->id.'" type="checkbox" role="switch" id="flexSwitchCheckChecked_'.$store->id.'" '.$active.'>
                        </div>';
                })
                ->editColumn('created_at', function ($store) {
                    return date('Y/m/d', strtotime($store->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.store.index');
    }

    public function create()
    {
        return view('Admin.CRUDS.store.parts.create');
    }

    public function store(StoreRequest $request)
    {
        $store = Store::create($request->validated());
        return $this->addResponse();
    }

    public function show(Store $store)
    {
        return view('store.show', compact('store'));
    }

    public function edit(Store $store)
    {
        return view('Admin.CRUDS.store.parts.edit', compact('store'));
    }

    public function update(StoreRequest $request, Store $store)
    {
        $store->update($request->validated());

        return $this->addResponse();

    }

    public function destroy(Store $store)
    {
        $store->delete();

        return $this->deleteResponse();
    }

    public function activate(Request $request)
    {
        $store = Store::findOrFail($request->id);
        $store->is_active == 1 ? $store->is_active = 0 : $store->is_active = 1;
        $store->save();
        return $this->successResponse();
    }//end fun

    public function viewProducts($storeId)
    {
        $store = Store::findOrFail($storeId);
        $products = \App\Models\Product::with(['productStores' => function($query) use ($storeId) {
            $query->where('store_id', $storeId);
        }])->get();

        return view('Admin.CRUDS.store.parts.products', compact('store', 'products'));
    }

    public function updateQuantities(Request $request, $storeId)
    {
        $store = Store::findOrFail($storeId);

        ProductStore::updateOrCreate(
            [
                'store_id' => $storeId,
                'product_id' => $request->product_id
            ],
            [
                'quantity' => $request->quantity
            ]
        );

        return response()->json(['message' => 'Quantity updated successfully']);
    }
}
