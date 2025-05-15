<?php

namespace App\Livewire\Products;
use Modules\Products\Models\Products;
use App\Models\WpPostMeta; 
use Livewire\Component;

class EditProduct extends Component
{
    public $product;
    public function mount($id){        
         $this->product = Products::find($id);
         $postMeta = WpPostMeta::where('post_id', $id)->get();
         foreach ($postMeta as  $meta) {
             if($meta['meta_key'] === '_regular_price'){
                $this->product['_regular_price'] = $meta['meta_value'];
             }       
             if($meta['meta_key'] === '_price'){
                $this->product['_price'] = $meta['meta_value'];
             }       
             if($meta['meta_key'] === '_categories'){
                $this->product['_categories'] = $meta['meta_value'];
             }       
             if($meta['meta_key'] === '_thumbnail_id'){
                $this->product['_thumbnail_id'] = $meta['meta_value'];
             }       
         }   
        dd($this->product);
    }
    
    public function render()
    {
        return view('livewire.products.edit-product');
    }
}
