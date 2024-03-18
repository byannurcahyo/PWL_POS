<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level'; // Mendefisikan nama tabel yang digunakan
    protected $primaryKey = 'level_id'; // Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['level_id', 'level_kode', 'level_nama']; // Mendefinisikan kolom yang dapat diisi dengan data
    public function user() {
        return $this->belongsTo(UserModel::class);
    }
}
