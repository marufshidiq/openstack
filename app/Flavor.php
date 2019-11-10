<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flavor extends Model
{
    protected $fillable = [
        'name', 'flavor_id', 'cpu', 'ram', 'hdd'
    ];
}
