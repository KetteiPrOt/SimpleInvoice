<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        return view('entities.products.index', [
            'products' => Product::all()
        ]);
    }

    public function create()
    {
        return view('entities.products.create');
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('products.show', $product->id);
    }

    public function show(Product $product)
    {
        return view('entities.products.show', [
            'product' => $product
        ]);
    }

    public function edit(Product $product)
    {
        return view('entities.products.edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update([
            'name' => $request->get('name'),
            'price' => $request->get('price')
        ]);
        return redirect()->route('products.show', $product->id);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
