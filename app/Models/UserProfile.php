<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'country_id',
        'state_id',
        'city_id',
        'gender',
        'hobbies',
        'bio',
    ];

    protected $casts = [
        'hobbies' => 'array',  // Ensure that hobbies is cast to an array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getProfilePictureUrlAttribute()
    {
        return asset('storage/'.$this->profile_picture);
    }
}
