<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'payer',
        'payee',
        'status'
    ];

    // One-to-Many (inverse)
    public function payer()
    {
        return $this->belongsTo(User::class,'payer','id');
    }

    // One-to-Many (inverse)
    public function payee()
    {
        return $this->belongsTo(User::class,'payee','id');
    }
}
