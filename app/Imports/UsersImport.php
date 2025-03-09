<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    public function model(array $row)
    {
        
        // Kiểm tra xem hàng có đủ dữ liệu không
        if (count($row) < 2) {
            return null; // Bỏ qua nếu không đủ dữ liệu
        }

        // Kiểm tra sự tồn tại của email
        if (User::where('email', $row[1])->exists()) {
            return null; // Nếu email đã tồn tại, trả về null để bỏ qua
        }

        return new User([
            'name' => $row[0] ?? 'Unknown', // Đặt giá trị mặc định nếu không có name
            'email' => $row[1],
            'password' => empty($row[2]) ? Hash::make('12345678') : Hash::make($row[2]),
        ]);
    }
}