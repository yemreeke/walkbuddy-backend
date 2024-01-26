<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IbanTransfers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'iban_no',
        'tl_price',
    ];
}
