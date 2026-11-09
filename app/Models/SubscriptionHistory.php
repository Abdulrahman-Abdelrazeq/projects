<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SubscriptionHistory extends Model
{
    protected $table = 'subscription_histories';

    protected $fillable = [
        'shop_id',
        'start_date',
        'end_date',
        'shop_type',
        'amount',
        'status',
        'notes',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    /**
     * Determine if this historical period is currently expired
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
     * Duration in days or months
     */
    public function getDurationAttribute()
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            $days = $start->diffInDays($end);
            $months = round($days / 30);
            if ($months >= 1) {
                return $months . ' شهر (' . $days . ' يوم)';
            }
            return $days . ' يوم';
        }
        return '-';
    }
}

