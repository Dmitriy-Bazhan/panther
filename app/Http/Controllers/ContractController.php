<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        return response()->json(['success' => true, 'contracts' => $contracts]);
    }

    public function show($id)
    {
        $contract = Contract::find($id);
        return response()->json(['success' => true, 'contract' => $contract]);
    }

    public function store(Request $request)
    {
        $contract = $request->post('contract');

        $rules = [
            'title' => 'required',
            'text' => 'required'
        ];

        Validator::make($contract, $rules)->validate();

        Contract::create([
            'title' => $contract['title'],
            'text' => $contract['text']
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $contract = $request->post('contract');

        $rules = [
            'title' => 'required',
            'text' => 'required'
        ];

        Validator::make($contract, $rules)->validate();

        Contract::where('id', $id)->update([
            'title' => $contract['title'],
            'text' => $contract['text']
        ]);

        return response()->json(['success' => true]);

    }

    public function destroy($id)
    {

    }

    public function downloadPdf($title)
    {

        $data = [
            'contract' => Contract::where('title', $title)->first()
        ];

        $pdf = PDF::loadView('pdf.contract', $data);
        return $pdf->download('test_pdf.pdf');
    }
}
