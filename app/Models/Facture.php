<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = [
        'client_id',
        'amount',
        'due_date',
        'status',
    ];


    protected function casts(): array
    {
        return [
            'due_date' => 'datetime:d-m-Y',
            'status' => StatusEnum::class,
            'created_at' => 'datetime:d-m-Y',
        ];
    }


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
