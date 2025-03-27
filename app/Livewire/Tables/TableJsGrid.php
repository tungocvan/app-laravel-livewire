<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use App\Models\Client;
use App\Models\Countries;

class TableJsGrid extends Component
{
    public $db;

    public function getClients(){
        return response()->json(Client::all());
    }
    public function getCountry(){
        return response()->json(Countries::all());
    }
    public function render()
    {
        return view('livewire.tables.table-js-grid');
    }
}
