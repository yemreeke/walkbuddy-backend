<?php

namespace App\Models;

use App\Models\CopyrightMessages;
use App\Models\Favorites;
use App\Models\Files;
use App\Models\Posts;
use App\Models\SuggestionMessages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        "surname",
        'email',
        'password',
        'is_deleted',
        "iban_no",
        "coin_count"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        "is_deleted",
        "created_at",
        "updated_at",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    // public function posts()
    // {
    //     return $this->hasMany(Posts::class, 'user_id', 'id');
    // }


    // public function files()
    // {
    //     return $this->hasMany(Files::class);
    // }

    // public function favorites()
    // {
    //     return $this->hasMany(Favorites::class);
    // }


    // public function suggestion()
    // {
    //     return $this->hasMany(SuggestionMessages::class);
    // }

    // public function copyright()
    // {
    //     return $this->hasMany(CopyrightMessages::class);
    // }

    // public function socialMedias()
    // {
    //     return $this->hasMany(UserSocialMedias::class, 'user_id');
    // }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}