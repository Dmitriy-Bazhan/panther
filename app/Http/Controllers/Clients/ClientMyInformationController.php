<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientMyInformationController extends Controller
{
    protected $clientRepo;

    public function __construct(ClientRepository $clientRepo)
    {
        parent::__construct();
        $this->clientRepo = $clientRepo;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'id' => 'required|numeric',
            'email' => 'required|email',
            'first_name' => 'required|max:250',
            'last_name' => 'required|max:250',
            'phone' => 'required|max:250',
            'zip_code' => 'required|max:250',
            'entity.description' => 'sometimes',
            'entity.gender' => 'required',
        ];

        $validator = Validator::make(json_decode($request->all('user')['user'], true), $rules);

        $errors = [];
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }

        $clients = $this->clientRepo->search($id);
        $client = $clients->first();

        $rules = [
            'file' => 'sometimes|file|mimes:jpeg,bmp,png',
        ];

        if ($request->file('file') || is_null($client->entity->original_photo)) {
            $validator = Validator::make($request->allFiles(), $rules);
            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors()->toArray());
            }
        }

        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if (!$this->clientRepo->update($client)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => []]);
        }

        if (!$this->clientRepo->uploadPhoto($request, $id)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => 'Cant upload']);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
