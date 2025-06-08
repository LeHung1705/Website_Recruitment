<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetQuaBaiKiemTra extends Model
{
    protected $table = 'ketquabaikiemtra';
    protected $fillable = [
        'nguoi_lam_id',
        'bai_kiem_tra_id',
        'diem_so',
        'ngay_lam',
        'don_ung_tuyen_id'
    ];

    protected $casts = [
        'ngay_lam' => 'datetime'
    ];

    // N:1 với NGUOIDUNG
    public function nguoidung()
    {
        return $this->belongsTo(User::class, 'nguoi_lam_id');
    }

    // N:1 với BAIKIEMTRA
    public function baikiemtra()
    {
        return $this->belongsTo(Baikiemtra::class, 'bai_kiem_tra_id');
    }

    // N:1 với DONUNGTUYEN
    public function donungtuyen()
    {
        return $this->belongsTo(Donungtuyen::class, 'don_ung_tuyen_id');
    }
}
