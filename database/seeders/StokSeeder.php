<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                //Pensil
                'barang_id' => 1,
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //Pulpen
                'barang_id' => 2,
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //Gula
                'barang_id' => 3,
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //Beras
                'barang_id' => 4,
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //Roti
                'barang_id' => 5,
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //Biskuit
                'barang_id' => 6,
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //Teh
                'barang_id' => 7,
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //Air Mineral
                'barang_id' => 8,
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //Paracetamol
                'barang_id' => 9,
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 110,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //Tramadol
                'barang_id' => 10,
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('t_stok')->insert($data);
    }
}
