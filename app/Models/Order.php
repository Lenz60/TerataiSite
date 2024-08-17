<?php

namespace App\Models;

use Faker\Factory as Faker;
use App\Models\OrdersAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'total_price',
        'track_code',
        'invoice_status'
    ];

    public function ordersPayment(){
        $this->hasOne(OrdersPayment::class);
    }

    public function ordersProduction(){
        $this->hasOne(OrdersProduction::class);
    }

    public function ordersAddress(){
        $this->hasOne(OrdersAddress::class);
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
