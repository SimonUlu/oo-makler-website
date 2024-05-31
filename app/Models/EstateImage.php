<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateImage extends Model
{
    protected $fillable = [
        'estate_id',       // Geändert von 'estate_id' zu 'estateid'
        'type',           // Hinzugefügt, da es im Array enthalten ist
        'url',
        'title',
        'text',           // Geändert von 'description' zu 'text'
        'originalname',   // Geändert von 'original_name' zu 'originalname'
        'modified',
        'estateMainId',   // Hinzugefügt, da es im Array enthalten ist
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estateid');
    }
}
