<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuItemCategory;
use App\Models\MenuItemImage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Category::factory(10)->create();

        // Categories Seeding
        $categories = [
            ['name'=>'Best Seller','description'=>'Foodie favourites'],
            ['name'=>'Main Course','description'=>'Good for health']
        ];

        $c=1;
        foreach($categories as $cat){
            $category = new Category;

            $category->parent_id    = 0;
            $category->name         = $cat['name'];
            $category->description  = $cat['description'];
            $category->sort_order   = $c;
    
            $category->save();
            $c++;    
        }

        // Menus Seeding
        $menus = [
            ['name'=>'Breakfast','description'=>'Good Start'],
            ['name'=>'Lunch','description'=>'Healthy Food'],
            ['name'=>'Dinner','description'=>'Relax Night']
        ];

        $m=1;
        foreach($menus as $mn){
            $menu = new Menu;

            $menu->name         = $mn['name'];
            $menu->description  = $mn['description'];
            $menu->sort_order   = $m;
    
            $menu->save();
            $m++;    
        }

        // Menu Items Seeding
        $menu_items = [
            ['name'=>'Chicken Noodles','description'=>'Chicken 65','price' => '20.50'],
            ['name'=>'Mutton Briyani','description'=>'Fresh Indian Mutton','price' => '25']
        ];

        $i=1;
        foreach($menu_items as $mi){
            $menu_item = new MenuItem;

            $menu_item->menu_id      = 2;
            $menu_item->name         = $mi['name'];
            $menu_item->description  = $mi['description'];
            $menu_item->price        = $mi['price'];
            $menu_item->sort_order   = $m;
    
            $menu_item->save();
            $i++;    
        }

        // Menu Item Category Seeding
        $menu_item_categories = [
            ['menu_item_id'=>1,'category_id'=>1],
            ['menu_item_id'=>1,'category_id'=>2],
            ['menu_item_id'=>2,'category_id'=>2]
        ];

        $i=1;
        foreach($menu_item_categories as $mic){
            $menu_item_category = new MenuItemCategory;

            $menu_item_category->menu_item_id   = $mic['category_id'];
            $menu_item_category->category_id    = $mic['category_id'];
    
            $menu_item_category->save();
            $i++;    
        }

        // Menu Item Image Seeding
        $menu_item_images = [
            ['menu_item_id'=>1,'image'=>'fried_rice.jpg'],
            ['menu_item_id'=>2,'image'=>'briyani.jpg']
        ];

        $i=1;
        foreach($menu_item_images as $mii){
            $menu_item_image = new MenuItemImage;

            $menu_item_image->menu_item_id   = $mii['menu_item_id'];
            $menu_item_image->image    = $mii['image'];
    
            $menu_item_image->save();
            $i++;    
        }
    }
}
