<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    use HasFactory;
    protected $table = 'furniture';
    protected $primaryKey = 'uuid';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $fillable = [
        'uuid',
        'image',
        'code',
        'description',
        'category',
        'wood_type',
        'width',
        'color',
        'length',
        'height',
        'price',
        'stock'
    ];
}
