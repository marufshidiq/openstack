<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'image_id', 'image_name', 'family', 'version', 'min_cpu', 'min_ram', 'min_hdd'
    ];
}
