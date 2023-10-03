<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $table = 'institutions';
    protected $primary_key = 'id';

    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    public function institution_type()
    {
        return $this->hasOne('App\Models\InstitutionType');
    }

    public function institution_accesses()
    {
        return $this->hasMany('App\Models\InstitutionAccess');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

}
