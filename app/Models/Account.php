<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Account extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id', 'user_id', 'balance', 'balanceMax', 'balanceMensual', 'currency', 'qrCode', 'status'
    ];

    protected static function boot()
    {
        parent::boot();

  
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transfersAsSender()
    {
        return $this->hasMany(Transfer::class, 'sender_id');
    }

    public function transfersAsReceiver()
    {
        return $this->hasMany(Transfer::class, 'receiver_id');
    }
}
