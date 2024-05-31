<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'plz_name',
        'plz_name_long',
        'plz_code',
        'krs_code',
        'lan_name',
        'lan_code',
        'krs_name',
        'geo_point_2d',
        'geometry',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'geo_point_2d' => 'array',
        'geometry' => 'array',
    ];
}
