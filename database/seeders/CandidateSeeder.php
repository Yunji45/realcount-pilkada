<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CandidateSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Ambil ID partai dan election dari tabel partais dan elections
        $partaiIds = DB::table('partais')->pluck('id')->toArray();
        $electionIds = DB::table('elections')->pluck('id')->toArray();

        for ($i = 0; $i < 8; $i++) {
            DB::table('candidates')->insert([
                'name' => $faker->name,
                'partai_id' => $faker->randomElement($partaiIds),
                'election_id' => $faker->randomElement($electionIds),
                'vision' => $faker->sentence(6),
                'mision' => $faker->sentence(10),
                'photo' => $faker->imageUrl(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}