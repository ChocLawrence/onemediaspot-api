<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';
    protected $primary_key = 'id';

    public function sizes()
    {
        return $this->belongsToMany('App\Models\Size');
    }
}
