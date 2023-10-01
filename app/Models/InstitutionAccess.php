<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionAccess extends Model
{
    use HasFactory;

    protected $table = 'institution_accesses';
    protected $primary_key = 'id';

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution');
    }

}
