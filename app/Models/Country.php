<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    protected $primary_key = 'id';


    public function regions()
    {
        return $this->hasMany('App\Models\Region');
    }

    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }


}
