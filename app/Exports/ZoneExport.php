<?php

namespace App\Exports;

use App\ZoneType;
use Maatwebsite\Excel\Concerns\FromCollection;

class ZoneExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ZoneType::all('name','zip_code','flag','color');
    }
}
