<?php

namespace App\Exports;

use App\Models\Translate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TranslateExport implements FromCollection, WithHeadings
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Translate::all();
    }

    public function headings(): array
    {
        return ['id', 'name', 'lang', 'data'];
    }
}
