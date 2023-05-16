<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'matakuliahs';

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class,'matakuliah_id','id');
    }

    public function kelaskuliah()
    {
        return $this->hasMany(Kelaskuliah::class,'id','matakuliah_id');
    }
}
