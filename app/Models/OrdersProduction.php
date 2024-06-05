<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class OrdersProduction extends Model
{
    use HasFactory;
    protected $table = 'orders_production';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'order_id',
        'production_status'
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
