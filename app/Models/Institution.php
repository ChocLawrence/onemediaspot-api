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

    public function company_type()
    {
        return $this->hasOne('App\Models\InstitutionType');
    }

    public function institution_accesses()
    {
        return $this->hasMany('App\Models\InstitutionAccess');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

}
