<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemImage extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'menu_item_images';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'menu_item_id', 'image'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function menu_item()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
