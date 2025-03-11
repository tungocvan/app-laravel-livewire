<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        
     
        // Kiểm tra xem hàng có đủ dữ liệu không
        if (count($row) < 2) {
            return null; // Bỏ qua nếu không đủ dữ liệu
        }

        // Kiểm tra sự tồn tại của email
        if (User::where('email', $row['email'])->exists()) {
            return null; // Nếu email đã tồn tại, trả về null để bỏ qua
        }
        
        return new User([
            'name' => $row['name'] ?? 'Unknown', // Đặt giá trị mặc định nếu không có name
            'email' => $row['email'],
            'password' => empty($row['password']) ? Hash::make('12345678') : Hash::make($row['password']),
        ]);
    }
}