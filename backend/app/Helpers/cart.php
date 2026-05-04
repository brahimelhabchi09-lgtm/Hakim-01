<?php

if (!function_exists('get_cart_key')) {
    function get_cart_key(int $produitId): string
    {
        return 'produit_' . $produitId;
    }
}

if (!function_exists('calculate_cart_total')) {
    function calculate_cart_total(array $cart): float
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        return round($total, 2);
    }
}
