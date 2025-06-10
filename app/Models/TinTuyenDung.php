<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tintuyendung extends Model
{
    protected $table = 'tintuyendung';
    protected $fillable = ['nguoi_dang_id', 'tieu_de', 'mo_ta', 'nganh_nghe', 'loai_cong_viec', 'dia_diem', 'luong', 'trang_thai'];

    // N:1 với NGUOIDUNG (người đăng tin)
    public function nguoidung()
    {
        return $this->belongsTo(User::class, 'nguoi_dang_id');
    }

    // Alias for nguoidung as nhatuyendung
    public function nhatuyendung()
    {
        return $this->belongsTo(User::class, 'nguoi_dang_id');
    }

    // 1:N với DONUNGTUYEN
    public function donungtuyens()
    {
        return $this->hasMany(Donungtuyen::class, 'tin_tuyen_dung_id');
    }
}

