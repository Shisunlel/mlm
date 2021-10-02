<?php

namespace App\Exports;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Admin::select('id', 'name', 'email', 'username', DB::raw('date(created_at)'), DB::raw('date(updated_at)'))->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'Username',
            'Created At',
            'Updated At',
        ];
    }
}
