<?php

namespace App\Helpers\Estates;

class EstateEntry
{
    protected $attributes = [];

    public function __construct(?array $entry = null)
    {
        if ($entry) {
            foreach ($entry as $key => $value) {
                if ($key === 'estate_images') {
                    // Handle estate images specifically
                    $this->attributes['images'] = collect($value)->map(function ($image) {
                        return [
                            'url' => $image['url'] ?? null,
                            'title' => $image['title'] ?? null,
                        ];
                    })->toArray();
                } elseif ($key === 'energieausweis_gueltig_bis' || $key === 'erstellt_am') {
                    // Handle date fields
                    $this->attributes[$key] = $value instanceof \Illuminate\Support\Carbon ? $value : \Illuminate\Support\Carbon::parse($value);
                } else {
                    // Handle other fields
                    $this->attributes[$key] = $value;
                }
            }
        }
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    public function toArray()
    {
        // Convert dates to string
        $attributes = array_map(function ($value) {
            return $value instanceof \Illuminate\Support\Carbon ? $value->toDateTimeString() : $value;
        }, $this->attributes);

        return [
            'id' => $attributes['objektnr_extern'] ?? null,
            'elements' => $attributes,
        ];
    }
}
