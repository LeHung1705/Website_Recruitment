<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiKiemTra extends Model
{
    protected $table = 'baikiemtra';
    protected $fillable = ['nguoi_tao_id', 'noi_dung', 'loai_bai'];

    // N:1 với NGUOIDUNG
    public function nguoidung()
    {
        return $this->belongsTo(User::class, 'nguoi_tao_id');
    }

    // 1:N với KETQUABAIKIEMTRA
    public function ketquabaikiemtras()
    {
        return $this->hasMany(Ketquabaikiemtra::class, 'bai_kiem_tra_id');
    }

}
