<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{

    use Upload_Files, ResponseTrait;

    public function index(Request $request)
    {
//        dd(14);
        if ($request->ajax()) {
            $categories = Category::query()->latest()->select(['id', 'name', 'is_active', 'created_at']);
            return Datatables::of($categories)
                ->addColumn('action', function ($category) {
                    return '
                    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="' . $category->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                            </svg>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" data-id="' . $category->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
                            </svg>
                        </span>
                    </button>
                ';
                })

                ->editColumn('is_active', function ($category) {
                    $active = $category->is_active == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch">
                           <input class="form-check-input activeBtn" data-id="' . $category->id . '" type="checkbox" role="switch" id="flexSwitchCheckChecked_' . $category->id . '" '.$active.'>
                        </div>';
                })
                ->editColumn('created_at', function ($category) {
                    return date('Y/m/d', strtotime($category->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.category.index');
    }

    public function create()
    {
        return view('Admin.CRUDS.category.parts.create');
    }

    public function store(CategoryRequest $request)
    {
       $category =  Category::create($request->validated());
return  $this->addResponse();
    }

    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('Admin.CRUDS.category.parts.edit' ,compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return  $this->addResponse();

    }

    public function destroy(Category $category)
    {
        $category->delete();

        return  $this->deleteResponse();
    }

    public function activate(Request $request)
    {

        $category = Category::findOrFail($request->id);
        $category->is_active == 1 ?  $category->is_active =0 :  $category->is_active = 1;
$category->save();
        return $this->successResponse();
    }


}
