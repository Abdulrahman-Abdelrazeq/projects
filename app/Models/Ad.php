<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ads';

    protected $fillable = [
        'title',
        'image',
        'order',
        'active',
        'link',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return asset('assets/admin-lte/dist/img/splash.png');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}

