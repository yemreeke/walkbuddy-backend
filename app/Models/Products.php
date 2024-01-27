<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "coin",
        "image_url"
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class, 'product_id', 'id');
    }
}
