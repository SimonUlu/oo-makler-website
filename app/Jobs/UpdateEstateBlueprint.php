<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Statamic\Facades\Collection;
use Symfony\Component\Yaml\Yaml;

class UpdateEstateBlueprint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $yamlPath = public_path('estate_fields/estate_fields.yaml');
        $yamlContents = Yaml::parseFile($yamlPath);

        $fields = $yamlContents['defaultFieldsEstate'];

        $statamicFields = [];

        foreach ($fields as $field) {
            $name = key($field);
            $type = current($field);
            $statamicType = $this->mapFieldTypeToStatamic($type);

            $statamicFields[] = [
                'handle' => strtolower($name),
                'field' => [
                    'type' => $statamicType,
                    'validate' => $type === 'integer' ? 'required|integer' : '',
                ],
            ];
        }

        $statamicFields[] = [
            'handle' => 'estate_images',
            'field' => [
                'type' => 'replicator',
                'sets' => [
                    'image' => [
                        'display' => 'Image',
                        'fields' => [
                            [
                                'handle' => 'url',
                                'field' => [
                                    'type' => 'text',
                                    'validate' => 'required|url',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $collection = Collection::findByHandle('estate_entries');

        $blueprint = $collection->entryBlueprint();

        $blueprint->setContents([
            'sections' => [
                'main' => [
                    'display' => 'Main',
                    'fields' => $statamicFields,
                ],
            ],
        ]);
        $blueprint->save();
    }

    private function mapFieldTypeToStatamic($type)
    {
        $mapping = [
            'integer' => 'integer',
            'string' => 'text',
            'float' => 'text',
            'boolean' => 'toggle',
            'date' => 'date',
        ];

        return $mapping[$type] ?? 'text';
    }
}
