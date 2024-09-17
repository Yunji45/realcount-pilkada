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
        if (isset($row['tps'])) {
            return new PollingPlace([
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
        return null; // Abaikan baris jika tidak ada TPS
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 1;
    }
}
