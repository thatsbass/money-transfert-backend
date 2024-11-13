<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'client_id', 'distributor_id', 'amount', 'transactionType'];

    protected static function boot()
    {
        parent::boot();

       
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

}
