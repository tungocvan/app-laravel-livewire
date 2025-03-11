<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserList extends Component
{
    use WithPagination, WithFileUploads;
    public $perPage = 10; // Số lượng bản ghi mặc định hiển thị
    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $file;
    public $isImporting = false;

    public function importFile()
    {
     
        $this->validate([
            'file' => 'required|file|max:32768|mimes:xlsx,xls,csv',
        ]);
        // dd($this->file);
        $this->isImporting = true; // Đặt trạng thái đang nhập

        try {
            Excel::import(new UsersImport, $this->file);
            $this->reset('file');
            session()->flash('message', 'Users imported successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        } finally {
            $this->isImporting = false; // Đặt lại trạng thái sau khi hoàn tất
        }
    }

    public function getUsersProperty()
    {
        return User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate((int) $this->perPage);
    }
    public function render()
    {
        return view('livewire.users.user-list');
    }
}
 