<?php

declare(strict_types=1);

namespace App\Console\Commands;
use Illuminate\Console\Command;

class AnalyzeCodeCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'code:analyze';

    /**
     * @var string
     */
    protected $description = 'Perform static analysis and styling checks.';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('Static analysis and styling checks started.');
        $this->info('Running Laravel Duster');
        exec('vendor/bin/duster lint');

        $this->info('Running PhpStan');
        exec('vendor/bin/phpstan --level=9 analyse -- ./app');
        $this->info('Static analysis and styling checks completed.');
    }
}
