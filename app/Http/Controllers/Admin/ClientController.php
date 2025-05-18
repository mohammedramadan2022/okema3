<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Client;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     use Upload_Files, ResponseTrait;


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $clients = Client::query()->when($request->search , function ($query) use ($request){
                $query->where('contact' , 'like', '%' . $request->search . '%');
                $query->orWhere('name' , 'like', '%' . $request->search . '%');
                $query->orWhere('email' , 'like', '%' . $request->search . '%');

                })->latest();
            return DataTables::of($clients)
                ->addColumn('action', function ($client) {
                    return '
                    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="'.$client->id.'">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                            </svg>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" data-id="'.$client->id.'">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
                            </svg>
                        </span>
                    </button>
                ';
                })
                ->editColumn('is_active', function ($client) {
                    $active = $client->is_active == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch">
                           <input class="form-check-input activeBtn" data-id="'.$client->id.'" type="checkbox" role="switch" id="flexSwitchCheckChecked_'.$client->id.'" '.$active.'>
                        </div>';
                })
                ->editColumn('created_at', function ($client) {
                    return date('Y/m/d', strtotime($client->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.client.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.CRUDS.client.parts.create' );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {

        $client = Client::create($request->validated());

        return $this->addResponse();

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
    public function edit(Client $client)
    {
        return view('Admin.CRUDS.client.parts.edit' ,compact('client'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return  $this->addResponse();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function activate(Request $request)
    {

        $client = Client::findOrFail($request->id);
        $client->is_active == 1 ? $client->is_active = 0 : $client->is_active = 1;
        $client->save();
        return $this->successResponse();
    }//end fun
}
