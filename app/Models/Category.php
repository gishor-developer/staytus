<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MenuItem;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name', 'description', 'sort_order'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function menu_items()
    {
        return $this->belongsToMany(MenuItem::class, 'menu_item_categories');
    }
}
