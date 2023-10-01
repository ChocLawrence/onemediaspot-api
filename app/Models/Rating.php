<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';
    protected $primary_key = 'id';

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
