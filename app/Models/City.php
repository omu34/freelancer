<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property-read \App\Models\Country|null $country
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @mixin \Eloquent
 */
class City extends Model
{
    use HasFactory;
    protected $table = 'city';


protected $fillable=[
    'name'
];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
