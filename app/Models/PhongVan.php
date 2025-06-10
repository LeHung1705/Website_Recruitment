<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhongVan extends Model
{
    protected $table = 'phongvan';
    protected $fillable = ['nguoi_to_chuc_id', 'don_ung_tuyen_id', 'thoi_gian', 'hinh_thuc', 'trang_thai'];

    // N:1 với NGUOIDUNG
    public function nguoidung()
    {
        return $this->belongsTo(User::class, 'nguoi_to_chuc_id');
    }

    // N:1 với DONUNGTUYEN
    public function donungtuyen()
    {
        return $this->belongsTo(Donungtuyen::class, 'don_ung_tuyen_id');
    }

    // 1:1 với KETQUAPHONGVAN
    public function ketquaphongvan()
    {
        return $this->hasOne(Ketquaphongvan::class, 'phong_van_id');
    }
}
