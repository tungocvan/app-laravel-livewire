<?php

namespace App\Livewire\Menu;

use Livewire\Component;

class MenuList extends Component
{
    public $menuItems;

    public function mount()
    {
        $filePath = config_path('menu.json');
        $this->menuItems = json_decode(file_get_contents($filePath), true);
    }

    public function render()
    {
        return view('livewire.menu.menu-list');
    }
}
