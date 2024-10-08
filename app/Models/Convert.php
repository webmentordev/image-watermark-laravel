<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convert extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'converted_image'
    ];
}
