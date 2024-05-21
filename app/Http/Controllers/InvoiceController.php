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

        $invoice = Invoice::orderByDesc('id')->first();

        if($invoice){
            $invoice = $invoice->id + 1;

            $counters = $counter->value + $invoice;

        } else {
            $counters = $counter->value;
        }

        $formData = [
            'number' => $counter->prefix . $counters,
            'customer_id' => null,
            'customer' => null,
            'date' => date('Y-m-d'),
            'due_date' => date('Y-m-d'),
            'reference' => null,
            'discount' => 0,
            'terms_and_conditions' => 'Default Terms and Conditions',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1
                ]
            ]
        ];

        return response()->json($formData);
    }
}
