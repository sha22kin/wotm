<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinSubmission extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'area_of_interest',
        'education',
        'district',
        'message',
        'status',
        'notes',
        'photo_path',
        'facebook_link',
    ];
}
