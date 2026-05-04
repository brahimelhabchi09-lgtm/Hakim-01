<?php

namespace App\Console\Commands;

use App\Models\Produit;
use Illuminate\Console\Command;

class SendLowStockAlerts extends Command
{
    protected $signature = 'alerts:low-stock {--threshold=5}';
    protected $description = 'Send alerts for low stock products';

    public function handle(): int
    {
        $threshold = $this->option('threshold');
        $products = Produit::where('stock', '<=', $threshold)->get();
        foreach ($products as $product) {
            $this->warn("Low stock: {$product->nom} ({$product->stock} remaining)");
        }
        return Command::SUCCESS;
    }
}
