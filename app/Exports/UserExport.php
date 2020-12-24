<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect(User::all());
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'password',
            'phone',
            'is active',
            'level'
        ];
    }
}
