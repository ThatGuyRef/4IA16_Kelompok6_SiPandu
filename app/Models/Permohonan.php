<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','type','jenis_keperluan','notes','status','dokumen_json','nik','nama','alamat','phone'];

    protected $casts = [
        'dokumen_json' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
