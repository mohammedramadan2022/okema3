<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ItemRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
    use Upload_Files, ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = Item::query()->latest()->select(['id', 'name', 'category_id', 'device_id', 'barcode', 'status', 'created_at']);
            return Datatables::of($items)
                ->addColumn('action', function ($item) {
                    return '
                    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="' . $item->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                            </svg>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" data-id="' . $item->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
                            </svg>
                        </span>
                    </button>
                ';
                })

                ->editColumn('status', function ($item) {
                    $active = $item->status == 'active' ? 'checked' : '';
                    return '<div class="form-check form-switch">
                           <input class="form-check-input activeBtn" data-id="' . $item->id . '" type="checkbox" role="switch" id="flexSwitchCheckChecked_' . $item->id . '" '.$active.'>
                        </div>';
                })
                ->editColumn('created_at', function ($item) {
                    return date('Y/m/d', strtotime($item->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.item.index');
    }

    public function create()
    {
        return view('Admin.CRUDS.item.parts.create');
    }

    public function store(ItemRequest $request)
    {
       $item = Item::create($request->validated());
       return $this->addResponse();
    }

    public function show(Item $item)
    {
        return view('Admin.CRUDS.item.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('Admin.CRUDS.item.parts.edit', compact('item'));
    }

    public function update(ItemRequest $request, Item $item)
    {
        $item->update($request->validated());
        return $this->addResponse();
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return $this->deleteResponse();
    }

    public function activate(Request $request)
    {
        $item = Item::findOrFail($request->id);
        $item->status = $item->status == 'active' ? 'inactive' : 'active';
        $item->save();
        return $this->successResponse();
    }
}
