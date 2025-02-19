<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_items';
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }
}