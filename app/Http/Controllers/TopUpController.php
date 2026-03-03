<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Game;
use App\Models\PaymentMethod;

class TopUpController extends Controller
{
    public function index()
    {
        $games = Game::where('is_active', true)->get();
        return view('topup.index', compact('games'));
    }

    public function show($slug)
    {
        $game = Game::where('slug', $slug)->with(['products' => function($q) {
            $q->where('is_active', true)->orderBy('price');
        }])->firstOrFail();

        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('topup.show', compact('game', 'paymentMethods'));
    }
}
