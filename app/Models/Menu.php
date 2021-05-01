<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'menus';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'title', 'description', 'sort_order'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
