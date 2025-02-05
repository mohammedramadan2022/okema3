<?php
// app/Http/Controllers/OwnerController.php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OwnerRequest;
use App\Models\Country;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countries =  Country::query()->latest();
            return Datatables::of($countries)
                ->addColumn('action', function ($country) {
                    return '
                    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="' . $country->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                            </svg>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" data-id="' . $country->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
                            </svg>
                        </span>
                    </button>
                ';
                })


                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.country.index');
    }

    public function create()
    {
        return view('Admin.CRUDS.country.parts.create');
    }

    public function store(OwnerRequest $request)
    {
        Owner::create($request->validated());
        return redirect()->route('owners.index')->with('success', 'Owner created successfully.');
    }

    public function show(Owner $owner)
    {
        return view('owners.show', compact('owner'));
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    public function update(OwnerRequest $request, Owner $owner)
    {
        $owner->update($request->validated());
        return redirect()->route('owners.index')->with('success', 'Owner updated successfully.');
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();
        return redirect()->route('owners.index')->with('success', 'Owner deleted successfully.');
    }
}
