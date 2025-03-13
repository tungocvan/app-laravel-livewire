<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;

class MenuEditor extends Component
{

    public $menuString;

    public function mount()
        {
            $filePath = public_path('menu.json');

            // Đọc nội dung file JSON
            $this->menuString = File::exists($filePath) ? File::get($filePath) : json_encode([]);
        }

        public function save()
        {
            $jsonMenu = $this->menuString;
            $filePath = public_path('menu.json');
            File::put($filePath, $jsonMenu);

            session()->flash('success', 'Menu updated successfully!');
        }
}