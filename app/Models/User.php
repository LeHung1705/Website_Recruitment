<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $table = 'users';
    protected $fillable = ['email', 'password', 'name', 'utype', 'phone'];

    // 1:N với TINTUYENDUNG
    public function tintuyendungs()
    {
        return $this->hasMany(Tintuyendung::class, 'nguoi_dang_id');
    }

    // 1:N với HOSOCANHAN
    public function hosocanhan()
    {
        return $this->hasOne(Hosocanhan::class, 'nguoi_dung_id');
    }

    // 1:N với DONUNGTUYEN
    public function donungtuyens()
    {
        return $this->hasMany(Donungtuyen::class, 'ung_vien_id');
    }

    // 1:N với BAIKIEMTRA
    public function baikiemtras()
    {
        return $this->hasMany(Baikiemtra::class, 'nguoi_tao_id');
    }

    // 1:N với KETQUABAIKIEMTRA
    public function ketquabaikiemtras()
    {
        return $this->hasMany(Ketquabaikiemtra::class, 'nguoi_lam_id');
    }

    // 1:N với PHONGVAN
    public function phongvans()
    {
        return $this->hasMany(Phongvan::class, 'nguoi_to_chuc_id');
    }

    // 1:N với THONGBAO
    public function thongbaos()
    {
        return $this->hasMany(Thongbao::class, 'nguoi_nhan_id');
    }
}
