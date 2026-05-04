<?php

namespace App\Console\Commands;

use App\Models\Commande;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportOrders extends Command
{
    protected $signature = 'orders:export {--format=csv}';
    protected $description = 'Export orders to CSV';

    public function handle(): int
    {
        $format = $this->option('format');
        $orders = Commande::with('user')->get();
        $filename = "orders_export_{$format}_" . now()->format('Y-m-d') . ".{$format}";
        Storage::put($filename, 'numero,user,total,statut,date' . PHP_EOL);
        foreach ($orders as $order) {
            Storage::append($filename, "{$order->numero},{$order->user->email},{$order->total},{$order->statut},{$order->created_at}");
        }
        $this->info("Exported {$orders->count()} orders to {$filename}");
        return Command::SUCCESS;
    }
}
