<?php

namespace App\Http\Controllers;

use App\Models\Tax as ModelsTax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Tax extends Controller
{
    /**
     * Show all data
     * @return void
     */
    function index()
    {
        $tax = ModelsTax::all();
        return view('pages.master.tax', ['title' => 'Master Pajak', 'taxs' => $tax]);
    }
    
    /**
     * Create data
     * @param mixed $req
     * @return void
     */
    function create(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'rate' => 'required',
            'description' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tax = new ModelsTax();
        $tax->name = $req->name;
        $tax->rate = $req->rate;
        $tax->description = $req->description;
        $tax->save();
        return redirect()->route('tax.create');
    }

    /**
     * Update data
     * @param mixed $req
     * @param mixed $tax
     * @return void
     */
    function update(Request $req, ModelsTax $tax)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'rate' => 'required',
            'description' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tax->update($req->all());
    }

    /**
     * Show modal for update
     * @param mixed $tax
     * @return void
     */
    public function show(ModelsTax $tax)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $tax
        ]);
    }

    /**
     * Delete data
     * @param mixed $tax
     * @return void
     */
    public function destroy(ModelsTax $tax)
    {
        $tax->delete();
    }

    /**
     * Search data by name
     * @param mixed $req
     * @return void
     */
    public function search(Request $req)
    {
        $tax = ModelsTax::where('name', 'like', "%" . $req->name . "%")->get();
        return view('pages.master.tax', ['title' => 'Master Pajak', 'taxs' => $tax]);
    }
}
