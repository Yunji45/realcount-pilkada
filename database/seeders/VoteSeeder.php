<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class VoteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil ID dari tabel terkait
        $candidateIds = DB::table('candidates')->pluck('id')->toArray();
        $pollingPlaceIds = DB::table('polling_places')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('votes')->insert([
                'candidate_id' => $faker->randomElement($candidateIds),
                'polling_place_id' => $faker->randomElement($pollingPlaceIds),
                'vote_count' => $faker->numberBetween(1, 500),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
