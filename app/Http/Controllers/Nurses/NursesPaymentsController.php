<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Http\Repositories\NurseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NursesPaymentsController extends Controller
{
    protected $nurseRepo;

    public function __construct(NurseRepository $nurseRepo)
    {
        parent::__construct();

        $this->nurseRepo = $nurseRepo;
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
        if (is_null($id) || !is_numeric($id)) {
            return abort(409);
        }

        $price = request('price');

        $rules = [
            'id' => 'required|numeric',
            'nurse_id' => 'required|numeric',
            'hourly_payment' => 'required|numeric|min:15',
            'weekend_surcharge' => 'required|in:yes,no',
            'weekend_surcharge_payment' => 'required|numeric|min:10',
            'holiday_surcharge' => 'required|in:yes,no',
            'holiday_surcharge_payment' => 'required|numeric|min:10',
            'fare_surcharge' => 'required|in:yes,no',
            'fare_surcharge_payment' => 'required|numeric|min:5|max:50',
        ];

        $validator = Validator::make($price, $rules);

        $errors = [];
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }

        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if(!$this->nurseRepo->updatePrice($price)){
            return abort(409);
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        //
    }
}
