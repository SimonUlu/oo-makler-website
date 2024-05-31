<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoArea extends Model
{
    use HasFactory;

    protected $table = 'geo_areas';

    protected $fillable = [
        'Year',
        'Kreis_code',
        'Kreis_name',
        'Kreis_name_short',
        'Type',
        'Land_code',
        'Land_name',
        'ISO_3166_3_Area_code',
        'geometry',
    ];

    protected $casts = [
        'id' => 'integer',
        'geo_point_2d' => 'array',
        'geometry' => 'array',
    ];
}
