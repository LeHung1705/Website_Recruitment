<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    protected $table = 'thongbao';
    protected $fillable = ['nguoi_nhan_id', 'noi_dung', 'trang_thai', 'thoi_gian_gui'];

    // N:1 với NGUOIDUNG
    public function nguoidung()
    {
        return $this->belongsTo(User::class, 'nguoi_nhan_id');
    }

}
