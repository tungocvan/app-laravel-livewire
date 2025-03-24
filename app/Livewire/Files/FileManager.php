<?php

namespace App\Livewire\Files;
use Livewire\Component;

class FileManager extends Component
{
    public $content="";
    public $name="";
    public $label='';
    public $labelClass= 'text-dark'; 
    public $config = [
        "height" => "200",
        "toolbar" => [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'lfm']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
    ];

    // public function mount() {
    //     if(!$this->name==""){
    //         $this->name = "editor-" . rand(1,9);
    //     }
        
    // }
  
    public function render()
    {
        return view('livewire.files.file-manager');
    }
}
