<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProductRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{

    use Upload_Files, ResponseTrait;

    public function index(Request $request)
    {
//        dd($request->all());
        if ($request->ajax()) {
            $products = Product::query()->when($request->search , function ($query) use ($request){
                $query->where('original_code' , 'like', '%' . $request->search . '%');
                $query->orWhere('code' , 'like', '%' . $request->search . '%');
                $query->orWhere('name' , 'like', '%' . $request->search . '%');

            })->with('category')->latest();
            return Datatables::of($products)
                ->addColumn('action', function ($product) {
                    $printUrl = route('admin.printProductBarcode', $product->id);

                    return '
            <a href="' . $printUrl . '" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Print Barcode">
                <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#2f5bdd">
                        <path d="M0 0h24v24H0z" fill="none"/>
                        <path d="M19 8H5c-1.1 0-2 .9-2 2v6h4v4h10v-4h4v-6c0-1.1-.9-2-2-2zm-3 10H8v-4h8v4zm3-8H5V6h14v4z"/>
                    </svg>
                </span>
            </a>

            <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="' . $product->id . '" title="Edit">
                <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                        <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                    </svg>
                </span>
            </button>

            <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" data-id="' . $product->id . '" title="Delete">
                <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
                        <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
                    </svg>
                </span>
            </button>
        ';
                })
                ->editColumn('is_active', function ($product) {
                    $active = $product->is_active == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch">
                           <input class="form-check-input activeBtn" data-id="'.$product->id.'" type="checkbox" role="switch" id="flexSwitchCheckChecked_'.$product->id.'" '.$active.'>
                        </div>';
                })
                ->editColumn('created_at', function ($product) {
                    return date('Y/m/d', strtotime($product->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.product.index');
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('Admin.CRUDS.product.parts.create' , compact('categories'));
    }

    public function store(ProductRequest $request)
    {

        $product = Product::create($request->validated());

        return $this->addResponse();
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', 1)->get();

        return view('Admin.CRUDS.product.parts.edit', compact('product' , 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return $this->addResponse();

    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->deleteResponse();
    }

    public function activate(Request $request)
    {

        $product = Product::findOrFail($request->id);
        $product->is_active == 1 ? $product->is_active = 0 : $product->is_active = 1;
        $product->save();
        return $this->successResponse();
    }//end fun


    public function printProductBarcode (Product $product)
    {

        return view('Admin.CRUDS.product.parts.printProductBarcode', compact('product'));
    }
}
