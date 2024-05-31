<?php

namespace App\Adapters;

// adapter class to convert oO-estates to statamic entry estates
class OnOfficeToEntryAdapter
{
    protected $fields;

    protected $estate;

    public function __construct(array $fields, array $estate)
    {
        $this->fields = $fields;
        $this->estate = $estate;
    }

    public function transform(): array
    {
        $entryData = [];

        foreach ($this->fields as $field) {
            $fieldName = key($field);
            $fieldType = current($field);

            // convert types
            $value = $this->estate['elements'][$fieldName] ?? null;
            switch ($fieldType) {
                case 'boolean':
                    $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                    break;
                case 'float':
                    $value = floatval($value);
                    break;
                case 'integer':
                    $value = intval($value);
                    break;
                case 'date':
                    // refactor date var type
                    break;
            }

            $entryData[$fieldName] = $value;
        }

        $images = collect($this->estate['elements']['images'] ?? [])->map(function ($image) {
            return [
                'type' => 'image',
                'url' => $image['url'],
            ];
        })->all();

        $entryData['estate_images'] = $images;
        $entryData['title'] = $entryData['objekttitel'];
        $entryData['objektnr_extern'] = intval($this->estate['elements']['Id']);

        return $entryData;
    }
}
