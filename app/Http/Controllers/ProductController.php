<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'nullable|string|min:2|max:255'
        ], attributes: ['search' => 'buscar']);
        if($validator->fails()){
            return redirect()
                ->route('products.index')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $query = Product::where(
            'user_id',
            Auth::user()->id
        );
        if(array_key_exists('search', $validated)){
            $search = '%' . $validated['search'] . '%';
            $query->whereRaw("name LIKE ?", [$search]);
        }
        $products = $query->orderBy('name')->paginate(15)->withQueryString();
        return view('entities.products.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        return view('entities.products.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'price' => 'required|decimal:0,2|min:0.01|max:999999.99'
        ], attributes: [
            'name' => 'nombre',
            'price' => 'precio'
        ]);
        if($validator->fails()){
            return redirect()
                ->route('products.create')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('products.show', $product->id);
    }

    public function show(Product $product)
    {
        $this->authorize($product);
        return view('entities.products.show', [
            'product' => $product
        ]);
    }

    public function edit(Product $product)
    {
        $this->authorize($product);
        return view('entities.products.edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize($product);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'price' => 'required|decimal:0,2|min:0.01|max:999999.99'
        ], attributes: [
            'name' => 'nombre',
            'price' => 'precio'
        ]);
        if($validator->fails()){
            return redirect()
                ->route('products.edit', $product->id)
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $product->update([
            'name' => $validated['name'],
            'price' => $validated['price']
        ]);
        return redirect()->route('products.show', $product->id);
    }

    public function destroy(Product $product)
    {
        $this->authorize($product);
        $product->delete();
        return redirect()->route('products.index');
    }

    private function authorize(Product $product): void
    {
        if($product->user_id !== Auth::user()->id){
            abort(403);
        }
    }
}
