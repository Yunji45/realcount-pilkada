<?php

namespace App\Imports;

use App\Models\Candidate;
use App\Models\PollingPlace;
use App\Models\Vote;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VoteImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari kandidat berdasarkan partai_id
        $candidate = Candidate::where('partai_id', $row['partai'])->first();

        // Jika kandidat tidak ditemukan, Anda bisa menangani sesuai kebutuhan, misalnya return null atau lempar exception
        if (!$candidate) {
            // Tindakan jika kandidat tidak ditemukan, misalnya skip row ini
            return null;
        }

        // Jika ditemukan, simpan vote dengan candidate_id yang ditemukan
        return new Vote([
            'candidate_id' => $candidate->id, // Ambil ID dari kandidat yang ditemukan
            'polling_place_id' => $row['tps'], // TPS diambil dari file Excel
            'vote_count' => $row['vote'], // Jumlah suara diambil dari file Excel
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
