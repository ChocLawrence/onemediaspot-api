<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $primary_key = 'id';

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status');
    }

    public function payment_preferences()
    {
        return $this->hasMany('App\Models\PaymentPreference');
    }

    public function followers()
    {
        return $this->hasMany('App\Models\Follower');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }
}
