<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'furniture_id',
        'preorder',
        'qty',
        'total_price'
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
