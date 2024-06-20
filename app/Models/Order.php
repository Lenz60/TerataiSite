<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'total_price',
        'track_code',
    ];

    public function ordersPayment(){
        $this->hasOne(OrdersPayment::class);
    }

    public function ordersProduction(){
        $this->hasOne(OrdersProduction::class);
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $faker = Faker::create();
    //         $model->id = $faker->uuid;
    //     });
    // }
}
