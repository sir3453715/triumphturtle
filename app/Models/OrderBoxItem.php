<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBoxItem extends Model
{
    use HasFactory;
    protected $table = 'orders_box';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'box_id', 'item_name', 'item_num', 'unit_price'
    ];

    public function box()
    {
        return $this->belongsTo(OrderBox::class,'box_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
