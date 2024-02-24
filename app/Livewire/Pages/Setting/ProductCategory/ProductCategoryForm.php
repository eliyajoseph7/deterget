<?php

namespace App\Livewire\Pages\Setting\ProductCategory;

use App\Models\Category;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class ProductCategoryForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $category;

    public $slug;

    protected $listeners = [
        'update_category' => 'editCategory'
    ];


    public function updatingCategory() {
        // $this->generateSlug();
    }

    public function addCategory()
    {
        $this->validate();

        $category = new Category;
        $category->name = $this->category;
        $category->slug = $this->slug;
        $category->user_id = auth()->user()->id;
        $category->save();

        $this->resetForm();
        $this->dispatch('category_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Category saved successfully!');
    }

    public function editCategory($id)
    {
        $this->action = 'update';
        $qs = Category::find($id);
        $this->id = $id;
        $this->category = $qs->name;
        $this->slug = $qs->slug;
        // $this->dispatch('update_active_category_row', $id);
    }

    public function updateCategory()
    {
        $this->validate();

        $qs = Category::find($this->id);
        $qs->name = $this->category;
        $qs->slug = $this->slug;

        $qs->save();

        $this->resetForm();
        $this->dispatch('category_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Category updated successfully!');
    }

    public function mount($id = null) {
        if($id) {
            $this->editCategory($id);
        }
    }

    public function generateSlug() {
        $slug = strtolower(str_replace(' ', '-', $this->category));
        $this->slug = $slug;
    }

    public function resetForm() {
        $this->reset();
    }
    public function render()
    {
        return view('livewire.pages.setting.product-category.product-category-form');
    }
}
