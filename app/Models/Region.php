<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'regions';
    protected $primary_key = 'id';


    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
}
