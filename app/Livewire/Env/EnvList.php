<?php

namespace App\Livewire\Env;

use Livewire\Component;
use Illuminate\Support\Facades\File;

class EnvList extends Component
{
    public $envVariables = [];
    public $selectedKey;
    public $selectedValue;

    public function mount()
    {
        $this->loadEnvVariables();
    }

    public function loadEnvVariables()
    {
        $envPath = base_path('.env');
        $this->envVariables = array_filter(file($envPath), 'trim');
    }

    public function openModal($key, $value)
    {
        $this->selectedKey = $key;
        $this->selectedValue = $value;
        $this->dispatchBrowserEvent('open-modal');
    }

    public function updateEnv()
    {
        $this->envVariables = array_map(function($line) {
            return strpos($line, $this->selectedKey) === 0 
                ? "{$this->selectedKey}={$this->selectedValue}" 
                : $line;
        }, $this->envVariables);
        
        $this->writeEnv();
        $this->resetModal();
    }

    public function deleteEnv($key)
    {
        $this->envVariables = array_filter($this->envVariables, function($line) use ($key) {
            return strpos($line, $key) === false;
        });
        $this->writeEnv();
    }

    public function writeEnv()
    {
        $envPath = base_path('.env');
        $newEnvContent = implode("", $this->envVariables);
        File::put($envPath, $newEnvContent);
        $this->loadEnvVariables();
    }

    public function resetModal()
    {
        $this->selectedKey = null;
        $this->selectedValue = null;
    }

    public function render()
    {
        return view('livewire.env.env-list');
    }
}