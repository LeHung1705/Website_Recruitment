<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonUngTuyen extends Model
{
    protected $table = 'donungtuyen';
    protected $fillable = ['ung_vien_id', 'tin_tuyen_dung_id', 'trang_thai'];

    // N:1 với NGUOIDUNG
    public function ungvien()
    {
        return $this->belongsTo(User::class, 'ung_vien_id');
    }

    // N:1 với TINTUYENDUNG
    public function tintuyendung()
    {
        return $this->belongsTo(Tintuyendung::class, 'tin_tuyen_dung_id');
    }

    // 1:1 với PHONGVAN
    public function phongvan()
    {
        return $this->hasOne(Phongvan::class, 'don_ung_tuyen_id');
    }

}
