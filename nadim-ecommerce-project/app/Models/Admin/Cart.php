<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cart extends Model
{
    protected $guarded = [];

    public function getFormattedCartDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y H:i'); //format('d-m-Y h:i:s A');
    }
}
