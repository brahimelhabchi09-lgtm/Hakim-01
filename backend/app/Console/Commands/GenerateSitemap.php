<?php

namespace App\Console\Commands;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml for SEO';

    public function handle(): int
    {
        $urls = collect();
        $urls->push(['loc' => url('/'), 'priority' => 1.0]);
        Category::whereNotNull('slug')->each(fn($c) =>
            $urls->push(['loc' => url("/categories/{$c->slug}"), 'priority' => 0.8]));
        Produit::where('statut', 'actif')->each(fn($p) =>
            $urls->push(['loc' => url("/produits/{$p->slug}"), 'priority' => 0.6]));
        $this->info("Generated sitemap with {$urls->count()} URLs.");
        return Command::SUCCESS;
    }
}
