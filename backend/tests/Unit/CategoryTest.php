<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Produit;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_category_has_many_produits()
    {
        $category = Category::factory()->create();
        Produit::factory()->count(3)->for($category)->create();
        $this->assertCount(3, $category->produits);
    }

    public function test_category_parent_relationship()
    {
        $parent = Category::factory()->create();
        $child = Category::factory()->for('parent', 'parent_id')->create();
        $this->assertEquals($parent->id, $child->parent->id);
    }

    public function test_category_children_relationship()
    {
        $parent = Category::factory()->create();
        Category::factory()->count(2)->for('parent', 'parent_id')->create();
        $this->assertCount(2, $parent->children);
    }

    public function test_category_scope_roots()
    {
        Category::factory()->create(['parent_id' => null]);
        Category::factory()->create(['parent_id' => null]);
        Category::factory()->create(['parent_id' => 1]);
        $this->assertEquals(2, Category::roots()->count());
    }
}
