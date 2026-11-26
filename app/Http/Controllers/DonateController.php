<?php

namespace App\Http\Controllers;

use App\Models\Donate;
use App\Models\User;
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



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $nickname)
    {
        $data = $request->validate([
            "sum" => "required|integer|min:10",
        ]);
        $channel = User::where('nickname', $nickname)->firstOrFail();
        $res = Http::post("http://localhost:8081/api/payments", [
            "sum" => $data["sum"],
            "webhook_url" => url('/api-rtub/payment-webhook')
        ]);
        $sum = $data['sum'] - 0.05 * $data['sum'];

        Donate::create([
            "user_id" => $channel->id,
            "donater" => auth()->user()->nickname,
            "sum" => $sum,
            "payment_id" => $res['payment_id'],
        ]);
        return response()->json([
            "pay_url" => $res->json("pay_url")
        ]);
    }
    public function updateStatus(Request $request) {
        $donate = Donate::query()->where('payment_id', $request->payment_id)->first();
        $donate->update(["status" => $request->status]);
        $user = User::find($donate->user_id);
        $user->increment('balance', $donate->sum);
        return response()->noContent();
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
