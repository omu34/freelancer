<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ProfiledFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Profiled newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profiled newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profiled query()
 * @mixin \Eloquent
 */
class Profile extends Model
{
    use HasFactory;

    // protected $table = 'profiles';

    protected $fillable = [
        'firstname',
        'lastname',
        'profilename',
        'country_id',
        'city_id',
        'user_id',
        'phone',
        'email',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}



