<?php

namespace App\Console\Commands;

use App\Models\Produit;
use Illuminate\Console\Command;

class CalculateProductRatings extends Command
{
    protected $signature = 'ratings:calculate';
    protected $description = 'Recalculate cached product ratings';

    public function handle(): int
    {
        Produit::chunk(100, function ($products) {
            foreach ($products as $product) {
                $avg = $product->avis()->approved()->avg('note') ?? 0;
                $product->update(['note_moyenne' => round($avg, 1)]);
            }
        });
        $this->info('Product ratings recalculated.');
        return Command::SUCCESS;
    }
}
