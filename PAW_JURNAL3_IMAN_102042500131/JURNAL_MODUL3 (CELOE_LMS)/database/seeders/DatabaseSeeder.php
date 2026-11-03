<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MataKuliah; // Jangan lupa import model MataKuliah
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Pengguna LMS (1 Dosen & 1 Mahasiswa)
        
        // TODO 1 : Buat akun awal untuk Dosen.
        // Menyimpan data dosen ke dalam variabel $dosen untuk diambil ID-nya nanti
        $dosen = User::updateOrCreate(
            ['email' => 'arif@kampus.ac.id'], 
            [
                'name' => 'arif simanjuntak',
                'password' => Hash::make('password123'), 
                'role' => 'dosen',
                'nomor_induk' => '123456789' 
            ]
        );

        // Buat akun awal untuk Mahasiswa
        $mahasiswa = User::updateOrCreate(
            ['email' => 'iman@kampus.ac.id'], 
            [
                'name' => 'Muhammad Iman Ramadhan Primora',
                'password' => Hash::make('password123'), 
                'role' => 'mahasiswa', 
                'nomor_induk' => '102042500' 
            ]
        );

        // Tambahan Data Mata Kuliah
        // Menggunakan updateOrCreate untuk mencegah duplikasi data jika seeder dijalankan ulang
        MataKuliah::updateOrCreate(
            ['kode_mk' => 'IF101'], 
            [
                'nama_mk' => 'Algoritma dan Pemrograman',
                'deskripsi' => 'Mata kuliah dasar untuk memahami logika, struktur kontrol, dan algoritma dalam pemrograman komputer.',
                'sks' => 3,
                'semester' => 'Ganjil 2026/2027',
                'dosen_id' => $dosen->id 
            ]
        );
    }
}