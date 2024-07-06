<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersAddress extends Model
{
    use HasFactory;
    protected $table = 'orders_address';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'order_id',
        'address',
        'country',
        'region',
        'zip',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $faker = Faker::create();
            $model->id = $faker->uuid;
        });
    }
}
