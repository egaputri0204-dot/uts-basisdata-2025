<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokterSeeder extends Seeder
{
   public function run(): void
    {
        DB::table('dokters')->insert([
            [
                'poliklinik_id' => 1,
                'kode_dokter' => 'DR001',
                'nama'    => 'dr. Siti Waindah',
                'spesialisasi' => 'Umum',
                'no_str' => 'STR202501',
                'no_sip' => 'SIP202316',
                'no_hp' => '0813456789',
                'email' => 'sitiw@rssehat.com',
                'pengalaman_tahun' => 5,
            ],
            [
                'poliklinik_id' => 2,
                'kode_dokter' => 'DR002',
                'nama'    => 'drg. Gina Regina',
                'spesialisasi' => 'Gigi',
                'no_str' => 'STR202417',
                'no_sip' => 'SIP378965',
                'no_hp' => '0856456729',
                'email' => 'gina@rssehat.com',
                'pengalaman_tahun' => 4,
            ],
        ]);
    }
}
