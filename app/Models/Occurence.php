<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occurence extends Model
{
    use HasFactory;

    protected $table = 'occurences';
    protected $primary_key = 'id';

    public function days()
    {
        return $this->hasMany('App\Models\Day');
    }

    public function frequencies()
    {
        return $this->hasMany('App\Models\Frequency');
    }

}
