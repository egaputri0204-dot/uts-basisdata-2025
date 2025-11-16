# 🏥 Hospital Management System – Database Documentation

Dokumentasi lengkap untuk *struktur database, **migration, dan **seeder* dalam Sistem Informasi Rumah Sakit.

---

## 📂 *Daftar Migration & Seeder *  
Semua migration dan seeder disatukan dalam satu blok kode.

```php
// =======================
//  MIGRATIONS
// =======================

/* 1. create_rumah_sakits_table */
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

/* 2. create_polikliniks_table */
Schema::create('polikliniks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('rumah_sakit_id')->constrained('rumah_sakits')->cascadeOnDelete();
    $table->string('nama_poliklinik', 150);
    $table->string('kode_poli', 20);
    $table->text('deskripsi')->nullable();
    $table->timestamps();
});

/* 3. create_dokters_table */
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

/* 4. create_jadwal_prakteks_table */
Schema::create('jadwal_prakteks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('dokter_id')->constrained('dokters')->cascadeOnDelete();
    $table->enum('hari', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']);
    $table->time('jam_mulai');
    $table->time('jam_selesai');
    $table->integer('kuota_pasien')->default(20);
    $table->timestamps();
});

/* 5. create_pasiens_table */
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

/* 6. create_kunjungans_table */
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

/* 7. create_obats_table */
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

/* 8. create_reseps_table */
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

/* 9. create_resep_items_table */
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

DB::table('rumah_sakits')->insert([
    ['nama' => 'RS Sehat Sentosa', 'alamat' => 'Jl. Merdeka No. 1', 'kota' => 'Jakarta', 'status' => 'aktif'],
]);

DB::table('polikliniks')->insert([
    ['rumah_sakit_id' => 1, 'nama_poliklinik' => 'Poli Umum', 'kode_poli' => 'PU'],
    ['rumah_sakit_id' => 1, 'nama_poliklinik' => 'Poli Gigi', 'kode_poli' => 'PG'],
]);

DB::table('dokters')->insert([
    ['rumah_sakit_id' => 1, 'nama' => 'Dr. Andi', 'jenis_kelamin' => 'L', 'spesialisasi' => 'Umum', 'status' => 'aktif'],
]);

DB::table('pasiens')->insert([
    ['no_rm' => 'RM001', 'nama' => 'Budi Santoso', 'jenis_kelamin' => 'L'],
]);

DB::table('obats')->insert([
    ['kode_obat' => 'OB001','nama_obat'=>'Paracetamol','sediaan'=>'tablet','kategori'=>'bebas','stok'=>100,'harga'=>5000],
]);