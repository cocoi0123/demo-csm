<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromArray, WithHeadings
{
    protected $data;
    public function __construct(array $data)
    {
        $this->data = $data;

    }
    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'permission_id',
            'code',
            'username',
            'name',
            'email',
            'tel',
            'register_date'

        ];
    }
}
