<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    use HasFactory;
    
    protected $table = 'adverts';
    protected $primary_key = 'id';

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status');
    }

    public function repeated_adverts()
    {
        return $this->hasMany('App\Models\RepeatedAdvert');
    }
    
}
