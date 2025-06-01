<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoSoCaNhan extends Model
{
    protected $table = 'hosocanhan';
    protected $fillable = ['nguoi_dung_id', 'hoc_van', 'kinh_nghiem', 'ky_nang'];

    // N:1 với NGUOIDUNG
    public function nguoidung()
    {
        return $this->belongsTo(User::class, 'nguoi_dung_id');
    }
}
