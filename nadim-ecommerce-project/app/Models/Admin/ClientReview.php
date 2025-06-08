<?php

namespace App\Models\Admin;

use App\Models\Admin\Client;
use Illuminate\Database\Eloquent\Model;

class ClientReview extends Model
{
    protected $guarded = [];

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
