<?php

namespace App\Livewire\Entities\Invoices\Create;

use App\Models\Product;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsInput extends Component
{
    use WithPagination;

    #[Locked]
    public array $products = [];

    public function render()
    {
        return view('livewire.entities.invoices.create.products-input', [
            'selectedProducts' => $this->querySelectedProducts(),
            'aviableProducts' => $this->queryAviableProducts()
        ]);
    }

    public function queryAviableProducts()
    {
        return Product::whereNotIn('id', $this->products)->simplePaginate(5);
    }

    public function querySelectedProducts()
    {
        return Product::whereIn('id', $this->products)->get();
    }

    public function pushProduct($product)
    {
        $this->products[] = $product;
    }
}
