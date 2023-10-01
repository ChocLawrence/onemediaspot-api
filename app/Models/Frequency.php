<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    use HasFactory;

    protected $table = 'frequencies';
    protected $primary_key = 'id';

    public function occurences()
    {
        return $this->belongsToMany('App\Models\Occurence');
    }
}
