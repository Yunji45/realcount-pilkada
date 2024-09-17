<?php

namespace App\Imports;

use App\Models\PollingPlace;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PollingPlaceImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new PollingPlace([
            'name' => $row['tps'],
            'provinsi_id' => $row['provinsi'],
            'kabupaten_id' => $row['kabupaten'],
            'kecamatan_id' => $row['kecamatan'],
            'kelurahan_id' => $row['kelurahan'],
            'rw' => $row['rw'],
            'DPT' => $row['dpt'],
            'periode' => now(),
            'latitude' => $row['latitude'],
            'longtitude' => $row['longtitude'],
            'status' => $row['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 1;
    }
}
