<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //This is where the customer logic will be located
    public function index()
    {
        $customers = Customer::orderByDesc('id')->get();

        return response()->json([
            'customers' => $customers
        ], 200);
    }
}
