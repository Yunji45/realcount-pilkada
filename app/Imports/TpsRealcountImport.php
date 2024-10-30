<?php

namespace App\Imports;

use App\Models\TpsRealcount;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TpsRealcountImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (isset($row['tps'])) {
            return new TpsRealcount([
                'name' => $row['tps'],
                'provinsi_id' => $row['provinsi'],
                'kabupaten_id' => $row['kabupaten'],
                'kecamatan_id' => $row['kecamatan'],
                'kelurahan_id' => $row['kelurahan'],
                'rw' => $row['rw'],
                'DPT' => $row['dpt'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                'status' => $row['status'],
                'periode' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return null;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
