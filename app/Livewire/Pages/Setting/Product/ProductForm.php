<?php

namespace App\Livewire\Pages\Setting\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\Uom;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class ProductForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $unit_price;
    #[Rule('required')]
    public $selling_price;
    #[Rule('required', as: "Unit of measure")]
    public $uom_id;
    #[Rule('required')]
    public $quantity;
    #[Rule('required')]
    public $total_pieces;

    #[Rule('required', as: 'Category')]
    public $category_id;

    protected $listeners = [
        'update_product' => 'editProduct'
    ];


    public function addProduct()
    {
        $this->validate();

        $product = new Product;
        $product->name = $this->name;
        $product->quantity = $this->quantity;
        $product->unit_price = $this->unit_price;
        $product->selling_price = $this->selling_price;
        $product->total_pieces = $this->total_pieces;
        $product->category_id = $this->category_id;
        $product->uom_id = $this->uom_id;
        $product->user_id = auth()->user()->id;
        $product->save();

        $this->resetForm();
        $this->dispatch('product_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Product saved successfully!');
    }

    public function editProduct($id)
    {
        $this->action = 'update';
        $qs = Product::find($id);
        $this->id = $id;
        $this->name = $qs->name;
        $this->quantity = $qs->quantity;
        $this->unit_price = $qs->unit_price;
        $this->selling_price = $qs->selling_price;
        $this->total_pieces = $qs->total_pieces;
        $this->category_id = $qs->category_id;
        $this->uom_id = $qs->uom_id;
        // $this->dispatch('update_active_product_row', $id);
    }

    public function updateProduct()
    {
        $this->validate();

        $qs = Product::find($this->id);
        $qs->name = $this->name;
        $qs->quantity = $this->quantity;
        $qs->unit_price = $this->unit_price;
        $qs->selling_price = $this->selling_price;
        $qs->total_pieces = $this->total_pieces;
        $qs->category_id = $this->category_id;
        $qs->uom_id = $this->uom_id;

        $qs->save();

        $this->resetForm();
        $this->dispatch('product_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Product updated successfully!');
    }

    public function mount($id = null) {
        if($id) {
            $this->editProduct($id);
        }
    }

    public function resetForm() {
        $this->dispatch('reset_category');
        $this->reset();
    }

    public function render()
    {
        $categories = Category::all();
        $uoms = Uom::all();
        return view('livewire.pages.setting.product.product-form', compact('categories', 'uoms'));
    }
}
