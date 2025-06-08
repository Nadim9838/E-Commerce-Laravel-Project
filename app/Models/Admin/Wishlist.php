<?php

namespace App\Models\Admin;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $guarded = [];

    public function getFormatedWishlistDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y H:i'); //format('d-m-Y h:i:s A');
    }

    // Join Client table
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
