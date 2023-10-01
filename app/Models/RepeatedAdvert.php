<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepeatedAdvert extends Model
{
    use HasFactory;

    protected $table = 'repeated_adverts';
    protected $primary_key = 'id';

    public function adverts()
    {
        return $this->belongsToMany('App\Models\Advert');
    }
}
