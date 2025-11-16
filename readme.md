
# UTS BASIS DATA – SISTEM INFORMASI HOSPITAL

**Nama:** Ega Putri Juliyanti
**NIM:** 20240803117
**Mata Kuliah:** Basis Data
**Tugas:** UTS – Sistem Informasi Rumah Sakit


## Gambaran Umum

Proyek ini merupakan tugas UTS mata kuliah Basis Data dengan studi kasus **Sistem Informasi Rumah Sakit**.
Database dibangun menggunakan:

✔ Laravel
✔ Migration & Seeder
✔ Relasional Database & Foreign Key
✔ Konvensi Eloquent ORM

### Entity Utama

* Rumah Sakit
* Poliklinik
* Dokter
* Jadwal Praktek
* Pasien
* Kunjungan
* Obat
* Resep & Resep Items


## Struktur Proyek

```
database/
 ├─ migrations/
 └─ seeders/
```


## Membuat Project

```bash
cd /root/boilerplate
./start.sh uts-basisdata
```


## Membuat Migration & Seeder

```bash
dcm RumahSakit
dcm Pasien
dcm Poliklinik
dcm Dokter
dcm Kunjungan
dcm Obat
dcm Resep
dcm JadwalPraktek
```


# MIGRATIONS

> Setiap tabel menggunakan foreign key & relasi database relasional


## 1 create_rumah_sakits_table

```php
Schema::create('rumah_sakits', function (Blueprint $table) {
           $table->id();
    $table->string('kode_rs')->unique(); 
    $table->string('nama');
    $table->string('tipe_rs'); 
    $table->string('alamat');
    $table->string('kota');
    $table->string('provinsi');
    $table->string('telepon')->nullable();
    $table->string('email')->nullable();
    $table->string('website')->nullable();
    $table->timestamps();
         });
```


## 2 create_polikliniks_table

```php
Schema::create('polikliniks', function (Blueprint $table) {
            $table->id();
    $table->foreignId('rumah_sakit_id')->constrained()->cascadeOnDelete();
    $table->string('kode_poli')->unique();
    $table->string('nama');
    $table->string('lantai')->nullable();
    $table->string('jam_operasional')->nullable();
    $table->timestamps();
        });
```


## 3 create_dokters_table

```php
Schema::create('dokters', function (Blueprint $table) {
            $table->id();
    $table->foreignId('poliklinik_id')->constrained()->cascadeOnDelete();

    $table->string('kode_dokter')->unique();
    $table->string('nama');
    $table->string('spesialisasi');
    $table->string('no_str')->nullable(); // Surat Registrasi
    $table->string('no_sip')->nullable(); // Surat Izin Praktek

    // kontak
    $table->string('no_hp')->nullable();
    $table->string('email')->nullable();

    $table->integer('pengalaman_tahun')->nullable();
    $table->timestamps();
        });
```


## 4 create_jadwal_prakteks_table

```php
 Schema::create('jadwal_prakteks', function (Blueprint $table) {
            $table->id();
    $table->foreignId('dokter_id')->constrained()->cascadeOnDelete();

    $table->enum('hari', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']);
    $table->time('jam_mulai');
    $table->time('jam_selesai');

    $table->boolean('is_libur')->default(false); // kalo dokter cuti
    $table->timestamps();
        });
```


## 5 create_pasiens_table

```php
Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
    $table->string('no_rm')->unique(); // Nomor Rekam Medis
    $table->string('nik')->unique();
    $table->string('nama');
    $table->enum('jenis_kelamin', ['L', 'P']);
    $table->date('tanggal_lahir');

    // Kontak
    $table->string('alamat');
    $table->string('kota')->nullable();
    $table->string('provinsi')->nullable();
    $table->string('no_hp')->nullable();

    // Data tambahan
    $table->string('golongan_darah')->nullable();
    $table->string('status_pernikahan')->nullable();
    $table->string('pekerjaan')->nullable();

    // Kontak darurat
    $table->string('kontak_darurat_nama')->nullable();
    $table->string('kontak_darurat_hp')->nullable();
    $table->string('kontak_darurat_hubungan')->nullable();

    $table->timestamps();
        });
```


## 6 create_kunjungans_table

```php
Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
    $table->foreignId('pasien_id')->constrained()->cascadeOnDelete();
    $table->foreignId('dokter_id')->constrained()->cascadeOnDelete();

    $table->dateTime('tanggal_kunjungan');
    $table->string('keluhan');
    $table->text('diagnosa')->nullable();
    $table->text('tindakan')->nullable();

    $table->integer('biaya_kunjungan')->default(0);
    $table->enum('status', ['menunggu', 'diperiksa', 'selesai'])
          ->default('menunggu');

    $table->timestamps();
        });
```


## 7 create_obats_table

```php
Schema::create('obats', function (Blueprint $table) {
            $table->id();
    $table->string('kode_obat')->unique();
    $table->string('nama');
    $table->string('kategori'); // Tablet, sirup, salep, kapsul, injeksi
    $table->string('jenis'); // generik / non generik
    $table->integer('stok')->default(0);
    $table->integer('harga')->default(0);
    $table->string('satuan'); // strip, botol, vial
    $table->timestamps();
        });
```


## 8 create_reseps_table

```php
Schema::create('reseps', function (Blueprint $table) {
            $table->id();
    $table->foreignId('kunjungan_id')->constrained()->cascadeOnDelete();
    $table->foreignId('obat_id')->constrained()->cascadeOnDelete();
    $table->integer('jumlah')->default(1);
    $table->string('aturan_pakai'); // contoh: "3x1 sesudah makan"
    $table->string('catatan')->nullable(); // note tambahan dokter

    $table->timestamps();
        });
```
 

# SEEDERS

```php
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
]);
```


```php
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
```


```php
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
```


```php
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
```


```php
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
```


```php
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
```


```php
DB::table('reseps')->insert([
            [
                'kunjungan_id' => 1,
                'obat_id' => 2,
                'jumlah' => 2,
                'aturan_pakai' => '3x1 setelah makan',
                'catatan' => 'Minum air putih yang banyak, Hindari gorengan, makanan pedas, santan, roti, kaffein',
            ],
        ]);
```


```php
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
```


## Menjalankan Seeder

```bash
dcm RumahSakit
dcm Pasien
dcm Poliklinik
dcm Dokter
dcm Kunjungan
dcm Obat
dcm Resep
dcm JadwalPraktek

# setelah semua file siap
dci
```
