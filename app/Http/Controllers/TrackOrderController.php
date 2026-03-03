<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function index()
    {
        return view('track.index');
    }

    public function search(Request $request)
    {
        $request->validate(['invoice' => 'required|string']);

        $order = Order::with(['game', 'product', 'paymentMethod'])
            ->where('invoice_number', $request->invoice)
            ->first();

        if (!$order) {
            return back()->withInput()->with('error', 'Invoice tidak ditemukan. Pastikan nomor invoice benar.');
        }

        return redirect()->route('order.invoice', $order->invoice_number);
    }
}
