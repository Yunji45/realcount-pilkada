<?php

namespace App\Imports;

use App\Models\Candidate;
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
        return new Vote([
            'candidate_id' => $row['partai'],
            'polling_place_id' => $row['tps'],
            'vote_count' => $row['vote'],
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
