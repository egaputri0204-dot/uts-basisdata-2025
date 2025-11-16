UTS BASIS DATA - SISTEM INFORMASI
Hospital

oleh

20240803117 - Ega Putri Juliyanti


Gambaran Umum
Proyek ini merupakan tugas UTS mata kuliah Basis Data dengan studi kasus Sistem Informasi Rumah Sakit.
Database dirancang menggunakan Laravel + Migration + Seeder dan mencakup elemen utama rumah sakit seperti:

Rumah Sakit
Poliklinik
Dokter
Pasien
Kunjungan
Obat
Resep

Seluruh schema dibuat dengan relasi foreign key, konvensi Laravel, dan konsep database relasional.

MEMBUAT PROJECT DIREKTORI
cd /root/boilerplate
./start.sh uts-basisdata

MEMBUAT MIGRATION & SEEDER  RUMAH SAKIT
dcm RumahSakit
dcm Pasien
dcm Polikinik
dcm Dokter
dcm Kunjungan
dcm Obat
dcm Resep
dcm JadwwaPraktek


```php
// =======================
//  MIGRATIONS
// =======================

/ 1. create_rumah_sakits_table /
Schema::create('rumah_sakits', function (Blueprint $table) {
    $table->id();
    $table->string('nama', 150);
    $table->text('alamat');
    $table->string('kota', 100);
    $table->string('no_telepon', 20)->nullable();
    $table->string('email', 150)->nullable();
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
});

/2. create_polikliniks_table/
Schema::create('polikliniks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('rumah_sakit_id')->constrained('rumah_sakits')->cascadeOnDelete();
    $table->string('nama_poliklinik', 150);
    $table->string('kode_poli', 20);
    $table->text('deskripsi')->nullable();
    $table->timestamps();
});

/3. create_dokters_table/
Schema::create('dokters', function (Blueprint $table) {
    $table->id();
    $table->foreignId('rumah_sakit_id')->constrained('rumah_sakits')->cascadeOnDelete();
    $table->string('nama', 150);
    $table->enum('jenis_kelamin', ['L', 'P']);
    $table->string('spesialisasi', 100);
    $table->string('no_telepon', 20)->nullable();
    $table->string('email', 150)->nullable();
    $table->string('sip', 100)->nullable();
    $table->enum('status', ['aktif', 'cuti', 'nonaktif'])->default('aktif');
    $table->timestamps();
});

/4. create_jadwal_prakteks_table/
Schema::create('jadwal_prakteks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('dokter_id')->constrained('dokters')->cascadeOnDelete();
    $table->enum('hari', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']);
    $table->time('jam_mulai');
    $table->time('jam_selesai');
    $table->integer('kuota_pasien')->default(20);
    $table->timestamps();
});

/5. create_pasiens_table/
Schema::create('pasiens', function (Blueprint $table) {
    $table->id();
    $table->string('no_rm')->unique();
    $table->string('nama', 150);
    $table->string('nik', 16)->nullable();
    $table->enum('jenis_kelamin', ['L', 'P']);
    $table->date('tanggal_lahir')->nullable();
    $table->text('alamat')->nullable();
    $table->string('no_telepon', 20)->nullable();
    $table->enum('golongan_darah', ['A','B','AB','O'])->nullable();
    $table->text('alergi')->nullable();
    $table->timestamps();
});

/6. create_kunjungans_table/
Schema::create('kunjungans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
    $table->foreignId('dokter_id')->constrained('dokters')->cascadeOnDelete();
    $table->foreignId('poliklinik_id')->constrained('polikliniks')->cascadeOnDelete();
    $table->text('keluhan')->nullable();
    $table->text('diagnosis')->nullable();
    $table->date('tanggal_kunjungan');
    $table->enum('status', ['menunggu','diperiksa','selesai'])->default('menunggu');
    $table->timestamps();
});

/7. create_obats_table/
Schema::create('obats', function (Blueprint $table) {
    $table->id();
    $table->string('kode_obat')->unique();
    $table->string('nama_obat');
    $table->enum('sediaan', ['tablet','kapsul','sirup','salep','ampul']);
    $table->enum('kategori', ['bebas','resep','narkotika']);
    $table->integer('stok')->default(0);
    $table->decimal('harga', 12,2)->default(0);
    $table->date('expired_at')->nullable();
    $table->timestamps();
});

/8. create_reseps_table/
Schema::create('reseps', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kunjungan_id')->constrained('kunjungans')->cascadeOnDelete();
    $table->foreignId('dokter_id')->constrained('dokters')->cascadeOnDelete();
    $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
    $table->date('tanggal_resep');
    $table->text('catatan')->nullable();
    $table->decimal('total_harga', 12,2)->default(0);
    $table->timestamps();
});

/9. create_resep_items_table/
Schema::create('resep_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('resep_id')->constrained('reseps')->cascadeOnDelete();
    $table->foreignId('obat_id')->constrained('obats')->cascadeOnDelete();
    $table->integer('jumlah');
    $table->text('aturan_pakai')->nullable();
    $table->decimal('subtotal', 12,2)->default(0);
    $table->timestamps();
});


// =======================
//  SEEDERS
// =======================
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

DB::table('jadwal_prakteks')->insert([
            [
                'dokter_id' => 1,
                'hari' => 'Rabu',
                'jam_mulai' => '09:00',
                'jam_selesai' => '15:00',
                'is_libur' => false,
            ],
            [
                'dokter_id' => 2,
                'hari' => 'Jumat',
                'jam_mulai' => '09:00',
                'jam_selesai' => '13:00',
                'is_libur' => false,
            ],
        ]);

DB::table('kunjungans')->insert([
            [
                'pasien_id' => 1,
                'dokter_id' => 1,
                'tanggal_kunjungan' => '2025-11-16 13:00:00',
                'keluhan' => 'Sakit Tenggorokan, muntah dan pusing',
                'diagnosa' => 'Asam Lambung dan Radang',
                'tindakan' => 'Pemberian obat',
                'biaya_kunjungan' => 100000,
                'status' => 'selesai',
            ],
        ]);

DB::table('obats')->insert([
            [
                'kode_obat' => 'OB001',
                'nama' => 'Omeprazole',
                'kategori' => 'Kapsul',
                'jenis' => 'Generik',
                'stok' => 150,
                'harga' => 5000,
                'satuan' => 'strip',
            ],
            [
                'kode_obat' => 'OB002',
                'nama' => 'Amoxicillin',
                'kategori' => 'Kapsul',
                'jenis' => 'Generik',
                'stok' => 300,
                'harga' => 12000,
                'satuan' => 'strip',
            ],
        ]);

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

DB::table('polikliniks')->insert([
            [
                'rumah_sakit_id' => 1,
                'kode_poli' => 'POLI001',
                'nama' => 'Poli Umum',
                'lantai' => '1',
                'jam_operasional' => '08:00 - 16:00',
            ],
            [
                'rumah_sakit_id' => 1,
                'kode_poli' => 'POLI002',
                'nama' => 'Poli Gigi',
                'lantai' => '2',
                'jam_operasional' => '08:00 - 14:00',
            ],
        ]);
        
DB::table('reseps')->insert([
            [
                'kunjungan_id' => 1,
                'obat_id' => 2,
                'jumlah' => 2,
                'aturan_pakai' => '3x1 setelah makan',
                'catatan' => 'Minum air putih yang banyak, Hindari gorengan, makanan pedas, santan, roti, kaffein',
            ],
        ]);

DB::table('rumah_sakits')->insert([
        [
            'kode_rs' => 'RS001',
            'nama' => 'RS Sehat Merdeka',
            'tipe_rs' => 'B',
            'alamat' => 'Jl. Merdeka No. 12',
            'kota' => 'Jakarta',
            'provinsi' => 'DKI Jakarta',
            'telepon' => '0211234567',
            'email' => 'info@rssehat.com',
            'website' => 'https://rssehat.com',
            'created_at' => now(),
        ],
    ]);

Setelah selesasi 
dcm RumahSakit
dcm Pasien
dcm Polikinik
dcm Dokter
dcm Kunjungan
dcm Obat
dcm Resep
dcm JadwwaPraktek
setelah nya dci
