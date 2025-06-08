<?php

namespace App\Models\Admin;

use App\Models\Admin\Client;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
