<?php

namespace App\Imports;

use App\ZoneType;
use Maatwebsite\Excel\Concerns\ToModel;

class ZoneImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[0] == null) return null;
        return new ZoneType([
            'name' => $row[0],
            'zip_code' => $row[1],
            'color' => $row[2],
            'flag' => $row[3],
        ]);
    }

}

