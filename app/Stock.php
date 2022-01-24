<?php

namespace App;

class Stock extends Model
{
    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
