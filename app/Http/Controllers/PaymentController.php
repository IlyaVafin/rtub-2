<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index() {
        return view('payment');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "sum" => "required|integer|min:10",
            "webhook_url" => "required|string|max:255"
        ]);
        $payment =  Payment::create([
            "sum" => $data['sum'],
            "webhook_url" => $data["webhook_url"]
        ]);
        return response()->json([
            "pay_url" => url('/payments/' . $payment->id),
            "payment_id" => $payment->id
        ]);
    }

    public function update(Request $request, Payment $payment) {
        if($payment->status != "pending") return back()->withErrors(['error' => "Платеж уже обработан"]);
        
        $data = $request->validate([
            "card_number" => "string|required"
        ]);

        $status = "";

        if($data['card_number'] == Str::replace(' ', '', $data['card_number'])) {}
    }
}
