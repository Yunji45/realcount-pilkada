<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class TPSSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Ambil ID dari tabel terkait
        $provinsiIds = DB::table('provinsis')->pluck('id')->toArray();
        $kabupatenIds = DB::table('kabupatens')->pluck('id')->toArray();
        $kecamatanIds = DB::table('kecamatans')->pluck('id')->toArray();
        $kelurahanIds = DB::table('kelurahans')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('polling_places')->insert([
                'name' => 'TPS ' . $faker->unique()->numberBetween(1, 100),
                'provinsi_id' => $faker->randomElement($provinsiIds),
                'kabupaten_id' => $faker->randomElement($kabupatenIds),
                'kecamatan_id' => $faker->randomElement($kecamatanIds),
                'kelurahan_id' => $faker->randomElement($kelurahanIds),
                'rw' => $faker->numberBetween(1, 10),
                'DPT' => $faker->numberBetween(100, 500),
                'periode' => $faker->date(),
                'latitude' => $faker->latitude(-10, 10),
                'longitude' => $faker->longitude(100, 140),
                'status' => $faker->randomElement(['Aktif', 'Non-aktif']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
