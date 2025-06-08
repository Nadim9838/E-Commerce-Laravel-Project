<?php

namespace App\Models\Admin;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    public function getFormattedCreationDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y H:i');
    }

    public function getFormattedValidityDateAttribute()
    {
        return Carbon::parse($this->validity)->format('d-m-Y');
    }
}
