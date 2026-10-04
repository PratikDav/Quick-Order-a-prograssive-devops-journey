<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'products' => Product::with('seller')->where('stock', '>', 0)->latest()->paginate(12),
        ]);
    }

    public function sellerDashboard(Request $request): View
    {
        abort_unless($request->user()->role === 'seller', 403);

        return view('seller.dashboard', [
            'products' => $request->user()->products()->latest()->get(),
            'orders' => Order::with(['product', 'buyer'])
                ->whereHas('product', fn ($query) => $query->where('seller_id', $request->user()->id))
                ->latest()
                ->get(),
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        abort_unless($request->user()->role === 'seller', 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:99999999'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
        ]);

        $request->user()->products()->create($validated);

        return back()->with('success', __('ui.messages.product_added'));
    }

    public function orderForm(Request $request, Product $product): View|RedirectResponse
    {
        abort_unless($request->user()->role === 'buyer', 403);

        if ($product->stock < 1) {
            return redirect()->route('home')->with('error', __('ui.messages.out_of_stock'));
        }

        return view('orders.create', compact('product'));
    }

    public function storeOrder(Request $request, Product $product): RedirectResponse
    {
        abort_unless($request->user()->role === 'buyer', 403);
        $validated = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:1000']]);

        $order = DB::transaction(function () use ($request, $product, $validated) {
            $lockedProduct = Product::whereKey($product->id)->lockForUpdate()->firstOrFail();

            if ($lockedProduct->stock < $validated['quantity']) {
                return null;
            }

            $lockedProduct->decrement('stock', $validated['quantity']);

            return Order::create([
                'buyer_id' => $request->user()->id,
                'product_id' => $lockedProduct->id,
                'quantity' => $validated['quantity'],
                'total' => $lockedProduct->price * $validated['quantity'],
                'status' => 'new',
            ]);
        });

        if (! $order) {
            return back()->withErrors(['quantity' => __('ui.messages.insufficient_stock')]);
        }

        return redirect()->route('buyer.orders')->with('success', __('ui.messages.order_placed'));
    }

    public function buyerOrders(Request $request): View
    {
        abort_unless($request->user()->role === 'buyer', 403);

        return view('orders.index', [
            'orders' => $request->user()->orders()->with('product.seller')->latest()->get(),
        ]);
    }
}