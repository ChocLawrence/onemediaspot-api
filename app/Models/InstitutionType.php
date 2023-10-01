<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionType extends Model
{
    use HasFactory;

    protected $table = 'institution_types';
    protected $primary_key = 'id';

    public function institutions(){
        return $this->belongsToMany('App\Models\Institution');
    }
}
