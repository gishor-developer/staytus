<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class MenuItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'menu_items';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'title', 'description', 'price', 'sort_order'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function image()
    {
        return $this->hasOne(MenuItemImage::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'menu_item_categories');
    }
}
