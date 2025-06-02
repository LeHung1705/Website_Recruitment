<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetQuaPhongVan extends Model
{
    protected $table = 'ketquaphongvan';
    protected $fillable = ['phong_van_id', 'diem_so', 'nhan_xet', 'ket_qua'];

    // N:1 với PHONGVAN
    public function phongvan()
    {
        return $this->belongsTo(Phongvan::class, 'phong_van_id');
    }
}
