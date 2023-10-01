<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $primary_key = 'id';

    public function countries()
    {
        return $this->belongsTo('App\Models\Country');
    }

}
