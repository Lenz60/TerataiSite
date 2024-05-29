<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'cart_id',
        'qty',
        'total_price',
    ];

    public function ordersPayment(){
        $this->hasOne(OrdersPayment::class);
    }

    public function ordersProduction(){
        $this->hasOne(OrdersProduction::class);
    }
}
