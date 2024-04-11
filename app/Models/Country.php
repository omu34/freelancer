<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'country';

    protected $fillable = [
        'name',
        'currency',
        'currencycode',
        'shortname',
        'countrycode',
        'url',
        'avatar',
        'description',
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }
}
