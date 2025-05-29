<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
    protected $fillable = ['name'];
}
