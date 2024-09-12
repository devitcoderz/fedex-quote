<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Display Cart
    public function index()
    {
        $cart = $this->cartService->getCart();
        $total = $this->cartService->getTotal();

        return view('cart.index', compact('cart', 'total'));
    }

    // Add Item to Cart
    public function add(Request $request)
    {
        $product = ['PRODIUCT DATA'];
        // $product = Product::find($request->id);
        $this->cartService->addToCart($product, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    // Update Cart
    public function update(Request $request, $productId)
    {
        $this->cartService->updateCart($productId, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    // Remove Item from Cart
    public function remove($productId)
    {
        $this->cartService->removeFromCart($productId);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    // Clear Cart
    public function clear()
    {
        $this->cartService->clearCart();

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
