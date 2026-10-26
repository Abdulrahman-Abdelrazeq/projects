<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    protected $table = 'instructions';

    protected $appends = ['image_url'];
    protected $fillable = [
        'notes',
        'image',
        'order',
        'active'
    ];
    public function getImageUrlAttribute()
    {
        if (file_exists('storage/' . $this->image))
        {
            return asset('storage/'.$this->image);
        }else{
            return  asset('assets/admin-lte/dist/img/splash.png');
        }
    }

}
