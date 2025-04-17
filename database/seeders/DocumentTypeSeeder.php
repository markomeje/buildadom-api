<?php

namespace Database\Seeders;
use App\Models\Document\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Document Type Seeder started.');
        $documents = [
            [
                'name' => 'Drivers Liscence',
                'description' => 'National Drivers Liscence',
                'code' => 'DRIVERS_LISCENCE',
                'double_sided' => true,
            ],
            [
                'name' => 'Voters Card',
                'description' => 'National Voters Card',
                'code' => 'VOTERS_CARD',
                'double_sided' => true,
            ],
            [
                'name' => 'International Passport',
                'description' => 'International Passport',
                'code' => 'INTERNATIONAL_PASSPORT',
                'double_sided' => true,
            ],
            [
                'name' => 'National Identity Card',
                'description' => 'National Identity Card',
                'code' => 'NATIONAL_IDENTITY_CARD',
                'double_sided' => true,
            ],
        ];

        foreach ($documents as $document) {
            DocumentType::updateOrCreate([
                'code' => $document['code'],
            ], $document);
        }
        $this->command->info('Document Type Seeder successful.');
    }
}
