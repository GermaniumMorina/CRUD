<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomersRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Models\customers;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // get methode
    public function index() {
        return CustomerResource::collection(customers::all());
    }
    public function show($id) {
        $customers = customers::findOrFail($id);
        return new CustomerResource($customers);
    }
    //post methode
    public function store(StoreCustomersRequest $request) {
        customers::create($request->validated());
        return response()->json("Customer Created");
    }
    //put methode
    public function update(StoreCustomersRequest $request, $id) {

        $customers = customers::findOrFail($id);
        $customers->update($request->validated());
        return response()->json("Customer updated");
    }
    public function destroy($id){
         $customers = customers::findOrFail($id);
         $customers->delete();
         return response()->json("Customer Deleted");
    }
}