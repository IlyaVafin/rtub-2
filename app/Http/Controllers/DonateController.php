<?php

namespace App\Http\Controllers;

use App\Models\Donate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DonateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function paymentWebhook(Request $request)
    {
       return response()->noContent();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "sum" => "required|integer|min:10",
        ]);

        $res = Http::post("http://localhost:8081/api/payments", [
            "sum" => $data["sum"],
            "webhook_url" => url('/api-rtub/payment-webhook')
        ]);
        return response()->json([
            "pay_url" => $res->json("pay_url")
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Donate $donate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donate $donate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donate $donate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donate $donate)
    {
        //
    }
}
