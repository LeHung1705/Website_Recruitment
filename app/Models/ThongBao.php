<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thongbao extends Model
{
    use HasFactory;

    protected $table = 'thongbao';
    protected $fillable = [
        'nguoi_nhan_id',
        'noi_dung',
        'trang_thai',
        'thoi_gian_gui',
        'loai_thong_bao',
        'bai_kiem_tra_id',
        'link'
    ];

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

    // Helper method to extract ID from link
    public function getPhongVanIdFromLink()
    {
        if (!$this->link || $this->loai_thong_bao !== 'phong_van') {
            return null;
        }
        
        // Extract the last segment of the URL which should be the ID
        $segments = explode('/', rtrim($this->link, '/'));
        $lastSegment = end($segments);
        
        // Extract just the numeric ID if there are query parameters
        if (strpos($lastSegment, '?') !== false) {
            $lastSegment = substr($lastSegment, 0, strpos($lastSegment, '?'));
        }
        
        return is_numeric($lastSegment) ? (int)$lastSegment : null;
    }

    // 1:1 với PHONGVAN
    public function phongvan()
    {
        $id = $this->getPhongVanIdFromLink();
        return $this->belongsTo(PhongVan::class, 'link', 'id')
                    ->where('id', $id);
    }
}
