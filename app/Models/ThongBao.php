<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thongbao extends Model
{
    use HasFactory;

    protected $table = 'thongbao';
    protected $fillable = ['nguoi_nhan_id', 'noi_dung', 'trang_thai', 'thoi_gian_gui', 'bai_kiem_tra_id'];

    // N:1 với NGUOIDUNG
    public function nguoidung()
    {
        return $this->belongsTo(User::class, 'nguoi_nhan_id');
    }

    // 1:1 với BAIBAIKIEMTRA
    public function baikiemtra()
    {
        return $this->belongsTo(Baikiemtra::class, 'bai_kiem_tra_id');
    }

    // 1:1 với KETQUABAIBAIKIEMTRA
    public function ketquabaikiemtras()
    {
        return $this->hasMany(Ketquabaikiemtra::class, 'bai_kiem_tra_id', 'bai_kiem_tra_id');
    }

}
