<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Products extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $products = [];
    public $productsEditingIndex = null;




    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['products'])) {
            $this->products = $this->offering->features['products'];
        } else {
            $this->products = [

            ];
        }

    }
    public function addProduct()
    {
        $this->products[] = 
            [
                'name' => '',
                'image' => '',
                'price' => '',
                'description' => '',
                'category' => '',
                'link' => '',
                'booth' => ''
            ];
        
    }
    public function editProduct($index)
    {
        $this->productsEditingIndex = $index;
    }

    public function saveProduct($index)
    {
        $this->productsEditingIndex = null;
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }
    public function saveProducts()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->products as $i => $product) {
            if (isset($product['image']) && is_object($product['image'])) {
                $path = $product['image']->store('products', 'public');
                $this->products[$i]['image'] = $path;
            }
        }

        //$this->offering->products = $this->products;
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['products' => $this->products]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ المنتجات بنجاح');
    }


    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.products');
    }
}
