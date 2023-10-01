<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $table = 'days';
    protected $primary_key = 'id';

    public function occurences()
    {
        return $this->belongsToMany('App\Models\Occurence');
    }
}
