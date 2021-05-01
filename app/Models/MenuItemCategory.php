<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemCategory extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'menu_item_categories';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'menu_item_id', 'category_id'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
