<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'phone',
    ];


    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d-m-Y',
        ];
    }


    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
}
