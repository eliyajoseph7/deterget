<?php

namespace App\Livewire\Pages\Setting\Product;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class ProductForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $price;

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
        $product->price = $this->price;
        $product->category_id = $this->category_id;
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
        $this->price = $qs->price;
        $this->category_id = $qs->category_id;
        // $this->dispatch('update_active_product_row', $id);
    }

    public function updateProduct()
    {
        $this->validate();

        $qs = Product::find($this->id);
        $qs->name = $this->name;
        $qs->price = $this->price;
        $qs->category_id = $this->category_id;

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
        return view('livewire.pages.setting.product.product-form', compact('categories'));
    }
}
