<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //
    public function index()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();

        return response()->json([
            'invoices' => $invoices
        ], 200);
    }

    public function searchInvoice(Request $request)
    {
        $search = $request->get('search');

        if($search){
            $invoices = Invoice::with('customer')->where('id', 'LIKE', "%$search")->get();
            return response()->json([
                'invoices' => $invoices
            ], 200);
        } else {
            return $this->index();
        }
    }

    public function createInvoice()
    {
        $counter = Counter::where('key', 'invoice')->first();
        $random = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::orderBy('id', 'DESC')->first();

        
    }
}
