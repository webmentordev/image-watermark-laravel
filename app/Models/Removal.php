<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Removal extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'bg_removed_image'
    ];
}
