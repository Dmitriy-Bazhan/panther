<?php

namespace App\Imports;

use App\Models\Translate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TranslateImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Translate([
            'id' => $row['id'],
            'name' => $row['name'],
            'lang' => $row['lang'],
            'data' => $row['data'],
        ]);
    }
}
