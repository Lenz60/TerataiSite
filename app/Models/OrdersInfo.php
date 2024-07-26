<?php

namespace App\Models;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersInfo extends Model
{
    use HasFactory;
    protected $table = 'orders_info';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'order_id',
        'phone_number',
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
