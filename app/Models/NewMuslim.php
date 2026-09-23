<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewMuslim extends Model
{
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'facebook_link',
        'photo_path',
    ];
}
