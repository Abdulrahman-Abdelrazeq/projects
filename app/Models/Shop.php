<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';
    public $timestamps = true;
    protected $guarded = ['id'];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];

    /**
     * Scope for subscription-based shops
     */
    public function scopeSubscriptions($query)
    {
        return $query->where('subscription', 1);
    }

    /**
     * Scope for regular shops (non-subscription)
     */
    public function scopeRegularShops($query)
    {
        return $query->where(function ($q) {
            $q->where('subscription', 0)->orWhereNull('subscription');
        });
    }

    /**
     * Check if the shop subscription is expired
     */
    public function isExpired()
    {
        if (empty($this->end_date)) {
            return false;
        }

        $endDateStr = is_string($this->end_date) ? $this->end_date : $this->end_date->format('Y-m-d');
        return $endDateStr < date('Y-m-d');
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return asset('assets/admin-lte/dist/img/splash.png');
    }
}
