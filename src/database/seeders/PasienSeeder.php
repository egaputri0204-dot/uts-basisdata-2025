<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pasiens')->insert([
            [
                'no_rm' => 'RM0001',
                'nik' => '3174051234560001',
                'nama' => 'Laura Prima',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2001-12-01',
                'alamat' => 'Jl. Delima No.37',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'no_hp' => '08123456789',
                'golongan_darah' => 'O',
                'status_pernikahan' => 'Belum Kawin',
                'pekerjaan' => 'Karyawan',
            ],
            [
                'no_rm' => 'RM0002',
                'nik' => '3174051234560002',
                'nama' => 'Riko Ramadhan',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1999-03-17',
                'alamat' => 'Jl. Dukuh No.21',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'no_hp' => '08129876543',
                'golongan_darah' => 'A',
                'status_pernikahan' => 'Kawin',
                'pekerjaan' => 'Barista',
            ],
        ]);
    }
}
