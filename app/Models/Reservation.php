<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
