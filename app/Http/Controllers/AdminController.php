<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Order;
use App\Models\Product;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ======== DASHBOARD ========
    public function dashboard()
    {
        $totalOrders    = Order::count();
        $totalRevenue   = Order::where('status', 'SUCCESS')->sum('total_amount');
        $pendingOrders  = Order::where('status', 'UNPAID')->count();
        $successOrders  = Order::where('status', 'SUCCESS')->count();
        $totalGames     = Game::count();
        $totalProducts  = Product::count();

        $recentOrders = Order::with(['game', 'product', 'paymentMethod'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'pendingOrders', 'successOrders',
            'totalGames', 'totalProducts', 'recentOrders'
        ));
    }

    // ======== GAMES CRUD ========
    public function games()
    {
        $games = Game::withCount('products')->orderByDesc('created_at')->get();
        return view('admin.games.index', compact('games'));
    }

    public function createGame()
    {
        return view('admin.games.form');
    }

    public function storeGame(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:games,slug|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url|max:500',
            'has_server_id' => 'nullable',
        ]);

        Game::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'category' => $request->category,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'has_server_id' => $request->has('has_server_id'),
            'is_active' => true,
        ]);

        return redirect()->route('admin.games')->with('success', 'Game berhasil ditambahkan!');
    }

    public function editGame(Game $game)
    {
        return view('admin.games.form', compact('game'));
    }

    public function updateGame(Request $request, Game $game)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:games,slug,' . $game->id,
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url|max:500',
            'has_server_id' => 'nullable',
        ]);

        $game->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'category' => $request->category,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'has_server_id' => $request->has('has_server_id'),
        ]);

        return redirect()->route('admin.games')->with('success', 'Game berhasil diperbarui!');
    }

    public function deleteGame(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games')->with('success', 'Game berhasil dihapus!');
    }

    // ======== PRODUCTS CRUD ========
    public function products()
    {
        $products = Product::with('game')->orderByDesc('created_at')->get();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $games = Game::where('is_active', true)->get();
        return view('admin.products.form', compact('games'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'provider_code' => 'nullable|string|max:100',
        ]);

        Product::create($request->only('game_id', 'name', 'price', 'provider_code') + ['is_active' => true]);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function editProduct(Product $product)
    {
        $games = Game::where('is_active', true)->get();
        return view('admin.products.form', compact('product', 'games'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'provider_code' => 'nullable|string|max:100',
        ]);

        $product->update($request->only('game_id', 'name', 'price', 'provider_code'));

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui!');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus!');
    }

    // ======== ORDERS ========
    public function orders()
    {
        $orders = Order::with(['game', 'product', 'paymentMethod'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        $order->load(['game', 'product', 'paymentMethod']);
        return view('admin.orders.detail', compact('order'));
    }

    // ======== PAYMENT METHODS ========
    public function paymentMethods()
    {
        $methods = PaymentMethod::orderBy('name')->get();
        return view('admin.payment-methods.index', compact('methods'));
    }

    public function createPaymentMethod()
    {
        return view('admin.payment-methods.form');
    }

    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:payment_methods,code|max:50',
            'fee_flat' => 'required|numeric|min:0',
            'fee_percent' => 'nullable|numeric|min:0|max:100',
            'instructions' => 'nullable|string',
        ]);

        PaymentMethod::create($request->only('name', 'code', 'fee_flat', 'fee_percent', 'instructions') + ['is_active' => true]);

        return redirect()->route('admin.payment-methods')->with('success', 'Metode pembayaran ditambahkan!');
    }

    public function editPaymentMethod(PaymentMethod $method)
    {
        return view('admin.payment-methods.form', compact('method'));
    }

    public function updatePaymentMethod(Request $request, PaymentMethod $method)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $method->id,
            'fee_flat' => 'required|numeric|min:0',
            'fee_percent' => 'nullable|numeric|min:0|max:100',
            'instructions' => 'nullable|string',
        ]);

        $method->update($request->only('name', 'code', 'fee_flat', 'fee_percent', 'instructions'));

        return redirect()->route('admin.payment-methods')->with('success', 'Metode pembayaran diperbarui!');
    }

    public function deletePaymentMethod(PaymentMethod $method)
    {
        $method->delete();
        return redirect()->route('admin.payment-methods')->with('success', 'Metode pembayaran dihapus!');
    }
}
