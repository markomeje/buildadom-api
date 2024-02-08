<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Document\DocumentType;
use App\Enums\Document\DocumentTypeStatusEnum;

class DocumentTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Seeding Document Types started.');
    DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
    DB::table('document_types')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

    $documents = [
      [
        'name' => 'Drivers Liscence' ,
        'description' => 'National Drivers Liscence',
        'code' => 'DRIVERS_LISCENCE',
        'double_sided' => true,
      ],
      [
        'name' => 'Voters Card' ,
        'description' => 'National Voters Card',
        'code' => 'VOTERS_CARD',
        'double_sided' => true,
      ],
      [
        'name' => 'International Passport' ,
        'description' => 'International Passport',
        'code' => 'INTERNATIONAL_PASSPORT',
        'double_sided' => true,
      ],
      [
        'name' => 'National Identity Card' ,
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
    $this->command->info('Document Type Seeder completed successfully.');
  }
}
