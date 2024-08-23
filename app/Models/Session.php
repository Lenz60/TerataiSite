<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $connection = 'mysql_baileys';
    protected $table = 'session';
    protected $primaryKey = 'pkId';

    public $incrementing = true;
    protected $keyType = 'integer';
}
