<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CenterRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Center;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class CenterController extends Controller
{
    use Upload_Files, ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $centers = Center::query()->latest()->select(['id', 'name', 'is_active', 'created_at']);
            return Datatables::of($centers)
                ->addColumn('action', function ($center) {
                    return '
                    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="' . $center->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                            </svg>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" data-id="' . $center->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
                            </svg>
                        </span>
                    </button>
                ';
                })

                ->editColumn('is_active', function ($center) {
                    $active = $center->is_active == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch">
                           <input class="form-check-input activeBtn" data-id="' . $center->id . '" type="checkbox" role="switch" id="flexSwitchCheckChecked_' . $center->id . '" '.$active.'>
                        </div>';
                })
                ->editColumn('created_at', function ($center) {
                    return date('Y/m/d', strtotime($center->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.center.index');
    }

    public function create()
    {
        return view('Admin.CRUDS.center.parts.create');
    }

    public function store(CenterRequest $request)
    {
       $center =  Center::create($request->validated());
       return  $this->addResponse();
    }

    public function show(Center $center)
    {
        return view('center.show', compact('center'));
    }

    public function edit(Center $center)
    {
        return view('Admin.CRUDS.center.parts.edit', compact('center'));
    }

    public function update(CenterRequest $request, Center $center)
    {
        $center->update($request->validated());
        return  $this->addResponse();
    }

    public function destroy(Center $center)
    {
        $center->delete();
        return  $this->deleteResponse();
    }

    public function activate(Request $request)
    {
        $center = Center::findOrFail($request->id);
        $center->is_active == 1 ?  $center->is_active = 0 :  $center->is_active = 1;
        $center->save();
        return $this->successResponse();
    }
}
