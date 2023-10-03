<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    protected $table = 'status_histories';
    protected $primary_key = 'id';

    public function advert()
    {
        return $this->belongsTo('App\Models\Advert');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution');
    }

    public function institution_access()
    {
        return $this->belongsTo('App\Models\InstitutionAccess');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }


}
