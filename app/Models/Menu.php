<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'url', 'icon', 'parent_id', 'order'];

    // Relasi dengan sub-menu
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
