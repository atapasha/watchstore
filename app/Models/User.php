<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; 
use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\Storage;
 class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'photo',
        'phone',
        'status',
        'is_admin',
        'user_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
 
    
    public static function saveImage($file)
   
    {
 
        if ($file) {
             $name = time() . '.' . $file->extension();
    
             $smallImage = Image::make($file->getRealPath());
            $bigImage =Image::make($file->getRealPath());
    
            // تغییر اندازه تصویر کوچک به 256 در 256
            $smallImage->resize(256, 256, function ($constraint) {
                $constraint->aspectRatio();
            });
    
            Storage::disk('local')->put(
                'admin/images/users/small/' . $name,
                (string) $smallImage->encode('jpg', 80)
            );
            
            Storage::disk('local')->put(
                'admin/images/users/big/' . $name,
                (string) $bigImage->encode('jpg', 80)
            );
            
    
            // برگرداندن نام فایل برای ذخیره در دیتابیس یا هر کار دیگر
            return $name;
        } else {
            return '';
        }
    }
    
}
