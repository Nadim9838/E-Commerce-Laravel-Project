<?php

namespace App\Models\Admin;
use Carbon\Carbon;
use App\Models\Admin\ClientAddress;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Client extends Authenticatable
{
    use Notifiable;

    protected $guard = 'client';

    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'dob', 'gender', 'profile_image'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    // Relationshipt with address
    public function address()
    {
        return $this->hasOne(ClientAddress::class);
    }
}
