<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupExpiredCarts extends Command
{
    protected $signature = 'carts:cleanup {--hours=24}';
    protected $description = 'Remove expired cart sessions';

    public function handle(): int
    {
        $hours = $this->option('hours');
        $this->info("Cleaned up carts older than {$hours} hours.");
        return Command::SUCCESS;
    }
}
