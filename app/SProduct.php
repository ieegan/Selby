<?php

namespace App;

use Nicolaslopezj\Searchable\SearchableTrait;

class SProduct extends Model
{
    use SearchableTrait;

    protected $table = 'products';

    protected $appends = ['onhand'];
    // protected $hidden = ['stocks'];

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.code' => 10,
            'products.description' => 10,
        ]
    ];

    public function stocks()
    {
        return $this->hasMany('App\Stock', 'product_id');
    }

    public function getOnhandAttribute()
    {
        if ($this->stocks)
        return $this->stocks->sum('quantity');
        else
        return 0;
    }
}
