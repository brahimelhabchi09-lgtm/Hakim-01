<template>
  <div class="space-y-6">
    <!-- Categories -->
    <div>
      <h3 class="font-semibold text-text-primary mb-3 flex items-center gap-2">
        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        Catégories
      </h3>
      <div class="space-y-2">
        <label
          v-for="cat in categories"
          :key="cat.id"
          class="flex items-center gap-3 cursor-pointer group"
        >
          <div class="relative">
            <input
              type="checkbox"
              :value="cat.slug"
              :checked="selectedCategories.includes(cat.slug)"
              @change="toggleCategory(cat.slug)"
              class="peer sr-only"
            />
            <div class="w-5 h-5 border-2 border-border rounded peer-checked:bg-accent peer-checked:border-accent transition-colors flex items-center justify-center">
              <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
              </svg>
            </div>
          </div>
          <span class="text-sm text-text-secondary group-hover:text-text-primary transition-colors">{{ cat.icon }} {{ cat.nom }}</span>
          <span class="text-xs text-text-muted ml-auto">({{ cat.produits_count || 0 }})</span>
        </label>
      </div>
    </div>

    <!-- Origins -->
    <div>
      <h3 class="font-semibold text-text-primary mb-3 flex items-center gap-2">
        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
        Origines
      </h3>
      <div class="space-y-2">
        <label
          v-for="origin in origins"
          :key="origin.id"
          class="flex items-center gap-3 cursor-pointer group"
        >
          <div class="relative">
            <input
              type="checkbox"
              :value="origin.code"
              :checked="selectedOrigins.includes(origin.code)"
              @change="toggleOrigin(origin.code)"
              class="peer sr-only"
            />
            <div class="w-5 h-5 border-2 border-border rounded peer-checked:bg-accent peer-checked:border-accent transition-colors flex items-center justify-center">
              <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
              </svg>
            </div>
          </div>
          <span class="text-sm text-text-secondary group-hover:text-text-primary transition-colors">{{ origin.drapeau }} {{ origin.pays }}</span>
        </label>
      </div>
    </div>

    <!-- Brands -->
    <div>
      <h3 class="font-semibold text-text-primary mb-3 flex items-center gap-2">
        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        Marques
      </h3>
      <div class="space-y-2">
        <label
          v-for="marque in marques"
          :key="marque.id"
          class="flex items-center gap-3 cursor-pointer group"
        >
          <div class="relative">
            <input
              type="checkbox"
              :value="marque.slug"
              :checked="selectedMarques.includes(marque.slug)"
              @change="toggleMarque(marque.slug)"
              class="peer sr-only"
            />
            <div class="w-5 h-5 border-2 border-border rounded peer-checked:bg-accent peer-checked:border-accent transition-colors flex items-center justify-center">
              <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
              </svg>
            </div>
          </div>
          <span class="text-sm text-text-secondary group-hover:text-text-primary transition-colors">{{ marque.nom }}</span>
        </label>
      </div>
    </div>

    <!-- Price Range -->
    <div>
      <h3 class="font-semibold text-text-primary mb-3 flex items-center gap-2">
        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Prix (MAD)
      </h3>
      <div class="space-y-3">
        <div class="flex items-center gap-2">
          <input
            type="number"
            :value="priceMin"
            @input="$emit('update:priceMin', $event.target.value)"
            placeholder="Min"
            class="input-field text-sm py-2"
          />
          <span class="text-text-muted">-</span>
          <input
            type="number"
            :value="priceMax"
            @input="$emit('update:priceMax', $event.target.value)"
            placeholder="Max"
            class="input-field text-sm py-2"
          />
        </div>
      </div>
    </div>

    <!-- Tags -->
    <div v-if="tags && tags.length > 0">
      <h3 class="font-semibold text-text-primary mb-3">Tags</h3>
      <div class="flex flex-wrap gap-2">
        <button
          v-for="tag in tags"
          :key="tag"
          @click="toggleTag(tag)"
          class="px-3 py-1 text-xs rounded-full border transition-all duration-fast"
          :class="selectedTags.includes(tag) 
            ? 'bg-accent border-accent text-white' 
            : 'border-border text-text-secondary hover:border-accent hover:text-accent'"
        >
          {{ tag }}
        </button>
      </div>
    </div>

    <button
      @click="clearFilters"
      class="btn-secondary w-full text-sm py-2"
    >
      Effacer les filtres
    </button>
  </div>
</template>

<script setup>
defineProps({
  categories: { type: Array, default: () => [] },
  origins: { type: Array, default: () => [] },
  marques: { type: Array, default: () => [] },
  tags: { type: Array, default: () => [] },
  selectedCategories: { type: Array, default: () => [] },
  selectedOrigins: { type: Array, default: () => [] },
  selectedMarques: { type: Array, default: () => [] },
  selectedTags: { type: Array, default: () => [] },
  priceMin: { type: [String, Number], default: '' },
  priceMax: { type: [String, Number], default: '' },
})

const emit = defineEmits([
  'update:selectedCategories',
  'update:selectedOrigins',
  'update:selectedMarques',
  'update:selectedTags',
  'update:priceMin',
  'update:priceMax',
  'apply',
])

function toggleCategory(slug) {
  const current = [...emit['selectedCategories'] || []]
  const idx = current.indexOf(slug)
  if (idx === -1) {
    current.push(slug)
  } else {
    current.splice(idx, 1)
  }
  emit('update:selectedCategories', current)
}

function toggleOrigin(code) {
  const current = [...emit['selectedOrigins'] || []]
  const idx = current.indexOf(code)
  if (idx === -1) {
    current.push(code)
  } else {
    current.splice(idx, 1)
  }
  emit('update:selectedOrigins', current)
}

function toggleMarque(slug) {
  const current = [...emit['selectedMarques'] || []]
  const idx = current.indexOf(slug)
  if (idx === -1) {
    current.push(slug)
  } else {
    current.splice(idx, 1)
  }
  emit('update:selectedMarques', current)
}

function toggleTag(tag) {
  const current = [...emit['selectedTags'] || []]
  const idx = current.indexOf(tag)
  if (idx === -1) {
    current.push(tag)
  } else {
    current.splice(idx, 1)
  }
  emit('update:selectedTags', current)
}

function clearFilters() {
  emit('update:selectedCategories', [])
  emit('update:selectedOrigins', [])
  emit('update:selectedMarques', [])
  emit('update:selectedTags', [])
  emit('update:priceMin', '')
  emit('update:priceMax', '')
  emit('apply')
}
</script>
