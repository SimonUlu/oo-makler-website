<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Statamic\Facades\Entry;

class ImportEstateImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $apiConnection,
        public int $estateId,
        public array $categories
    ) {
        $this->queue = 'sync-onoffice';
    }

    /**
     * Execute the job.
     *
     * @throws \Exception
     */
    public function handle(): void
    {
        // get api handler
        $apiHandler = new \App\Services\OnOffice\Connectors\EstateConnector();
        // get total records
        $images = $apiHandler
            ->setConnector($this->apiConnection)
            ->getEstateImages(
                recordId: $this->estateId,
                categories: $this->categories,
            );

        foreach ($images['data']['records'] as $image) {
            $estateImages[] = [
                'title' => $this->sanitizeString($image['elements'][0]['title']),
                'type' => $this->sanitizeString($image['elements'][0]['type']),
                'url' => $this->sanitizeString($image['elements'][0]['url']),
                'originalname' => $this->sanitizeString($image['elements'][0]['originalname']),
                'modified' => $this->sanitizeString(date('Y-m-d', $image['elements'][0]['modified'])),
                'text' => $this->sanitizeString($image['elements'][0]['text']),
            ];
        }

        $estate = Entry::query()->where('id_internal', $this->estateId)->first();
        // set images
        $estate->set('estate_images', []);
        $estate->set('estate_images', $estateImages ?? []);
        // save estate
        $estate->save();
    }

    /**
     * Sanitize string to ensure it is properly encoded in UTF-8.
     */
    private function sanitizeString(string $string): string
    {
        // Trim whitespace and convert to UTF-8
        $string = trim($string);

        return mb_convert_encoding($string, 'UTF-8', 'UTF-8');
    }
}
