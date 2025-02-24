<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSteps extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'step_count',
    ];

    protected $casts = [
        "step_count" => "integer",
    ];

}
