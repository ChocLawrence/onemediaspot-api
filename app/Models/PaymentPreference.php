<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPreference extends Model
{
    use HasFactory;
    protected $table = 'payment_preferences';
    protected $primary_key = 'id';

    public function services()
    {
        return $this->belongsToMany('App\Models\Service');
    }

}
