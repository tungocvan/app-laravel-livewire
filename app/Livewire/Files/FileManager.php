<?php

namespace App\Livewire\Files;
use Livewire\Component;

class FileManager extends Component
{
    public $content = ''; // Biến dùng wire:model

    public function updatedContent(){
       // dd($this->content);
       $this->js("alert('updatedContent')");
       
    } 
    
    public function hanlderSubmit(){
        //dd($this->content);
        //$this->js("alert('hanlderSubmit')"); 
        //return $this->content;
    } 
    

    public function render()
    {
        return view('livewire.files.file-manager');
    }
}
