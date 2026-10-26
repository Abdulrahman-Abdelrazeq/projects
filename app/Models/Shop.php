<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';
    public $timestamps = true;
    protected $guarded = ['id'];

//    public function getImageUrlAttribute()
//    {
//        if (file_exists('storage/' . $this->image))
//        {
//            return asset('storage/'.$this->image);
//        }else{
//            return  asset('assets/admin-lte/dist/img/splash.png');
//        }
//    }

}