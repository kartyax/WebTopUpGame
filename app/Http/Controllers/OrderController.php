<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Models\PaymentMethod;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'user_id_input' => 'required',
            'server_id_input' => 'nullable',
            'product_id' => 'required|exists:products,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'phone' => 'required',
        ]);

        $product = Product::findOrFail($request->product_id);
        $payment = PaymentMethod::findOrFail($request->payment_method_id);
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(uniqid());

        $amount = $product->price;
        $fee = $payment->fee_flat + ($amount * ($payment->fee_percent / 100));
        $total = $amount + $fee;

        $order = Order::create([
            'invoice_number' => $invoiceNumber,
            'user_id' => auth()->id(),
            'game_id' => $request->game_id,
            'product_id' => $product->id,
            'payment_method_id' => $payment->id,
            'customer_phone' => $request->phone,
            'game_user_id' => $request->user_id_input,
            'game_server_id' => $request->server_id_input,
            'original_amount' => $amount,
            'fee' => $fee,
            'total_amount' => $total,
            'status' => 'UNPAID',
        ]);

        return redirect()->route('order.invoice', $order->invoice_number);
    }

    public function invoice($invoice)
    {
        $order = Order::where('invoice_number', $invoice)->with(['game', 'product', 'paymentMethod'])->firstOrFail();
        return view('order.invoice', compact('order'));
    }

    public function simulatePay($invoice)
    {
        $order = Order::where('invoice_number', $invoice)->firstOrFail();
        
        if($order->status === 'UNPAID') {
            $order->update(['status' => 'SUCCESS']); // Simulate immediate success
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil disimulasikan!');
    }
}
