<template>
  <footer class="bg-secondary text-white">
    <div class="container-custom py-12">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div>
          <h3 class="text-xl font-heading font-bold mb-4">
            <span class="text-primary">Wolf</span>Store
          </h3>
          <p class="text-gray-300 text-sm leading-relaxed">
            Votre boutique de produits bresiliens authentiques au Maroc.
            Des saveurs du Bresil directement chez vous.
          </p>
        </div>

        <div>
          <h4 class="font-semibold mb-4">Navigation</h4>
          <ul class="space-y-2 text-sm text-gray-300">
            <li><router-link to="/" class="hover:text-primary transition-colors">Accueil</router-link></li>
            <li><router-link to="/catalogue" class="hover:text-primary transition-colors">Catalogue</router-link></li>
            <li><router-link to="/wishlist" class="hover:text-primary transition-colors">Favoris</router-link></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold mb-4">Categories</h4>
          <ul class="space-y-2 text-sm text-gray-300">
            <li><router-link to="/catalogue?category=cafe-acai" class="hover:text-primary transition-colors">Cafe & Açaí</router-link></li>
            <li><router-link to="/catalogue?category=doces-chocolate" class="hover:text-primary transition-colors">Doces & Chocolate</router-link></li>
            <li><router-link to="/catalogue?category=bebidas" class="hover:text-primary transition-colors">Bebidas</router-link></li>
            <li><router-link to="/catalogue?category=snacks-appetizers" class="hover:text-primary transition-colors">Snacks</router-link></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold mb-4">Contact</h4>
          <ul class="space-y-2 text-sm text-gray-300">
            <li>Casablanca, Maroc</li>
            <li>+212 699 08 48 41</li>
            <li>contact@wolfstore.ma</li>
          </ul>
        </div>
      </div>

      <div class="border-t border-gray-600 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-sm text-gray-400">
          © 2026 WolfStore. Tous droits reserves.
        </p>
        <div class="flex items-center gap-4 text-sm text-gray-400">
          <a href="#" class="hover:text-primary transition-colors">Politique de confidentialite</a>
          <a href="#" class="hover:text-primary transition-colors">Conditions d'utilisation</a>
        </div>
      </div>
    </div>
  </footer>
</template>
