<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LevelModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $guarded = [];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    // use HasFactory;

    // protected $table = 'm_user'; // Mendefisikan nama tabel yang digunakan
    // protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel yang digunakan
    // protected $fillable = ['level_id', 'username', 'nama', 'password']; // Mendefinisikan kolom yang dapat diisi dengan data
    // public function level(): BelongsTo {
    //     return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    // }
}
