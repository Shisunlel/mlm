<?php

namespace App\Imports;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AdminsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $admin = new Admin([
            'name' => $row['name'],
            'username' => $row['username'],
            'password' => Hash::make($row['password']),
            'email' => $row['email'],
            'created_by' => auth('admin')->user()->id,
        ]);
        $admin->syncRoles($row['role']);
        return $admin;
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:160',
            '*.email' => 'required|string|email|max:160|unique:admins',
            '*.password' => 'required|min:6',
            '*.username' => 'required|alpha_num|unique:admins|min:4',
        ];
    }
}
