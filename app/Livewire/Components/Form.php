<?php

namespace App\Livewire\Components;
use Livewire\Component;

class Form extends Component
{
    public $category='Sports';
    public function handleSubmit($data){
        dd($data);
    }
    public function save(){
        dd($this->category);
    }
    public function render()
    {
        return view('livewire.components.form');
    }
}
