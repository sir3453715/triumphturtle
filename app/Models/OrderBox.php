<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBox extends Model
{
    use HasFactory;
    protected $table = 'orders_box';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'box_weight', 'box_length', 'box_width', 'box_height', 'box_price', 'tracking_number'
    ];

    public function boxitems()
    {
        return $this->hasMany(OrderBoxItem::class,'box_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
