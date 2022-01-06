<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'sailing_id', 'seccode', 'serial_number', 'person_number', 'type', 'parent_id', 'status', 'pay_status', 'total_price',
        'shipment_use', 'sender_name', 'sender_phone', 'sender_address', 'sender_company', 'sender_taxid', 'sender_email',
        'for_name', 'for_phone', 'for_address', 'for_company', 'for_taxid', 'invoice', 'captcha','updateToken'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function sailing()
    {
        return $this->belongsTo(SailingSchedule::class,'sailing_id','id');
    }
    public function parentOrder()
    {
        return Order::find($this->parent_id);
    }
    public function box()
    {
        return $this->hasMany(OrderBox::class,'order_id');
    }
    public function boxListData(){
        $data = array();

        $boxListData = DB::table('orders')
            ->select(DB::raw('count(orders.person_number) as person, SUM(orders.total_price) as price'))
            ->where('serial_number', '=', $this->serial_number)->first();
        $order_ids = Order::where('serial_number', '=', $this->serial_number)->pluck('id');
        $box_count = OrderBox::whereIn('order_id',$order_ids)->count();

        $data = [
            'person'=>$boxListData->person,
            'price'=>$boxListData->price,
            'box_count'=>$box_count,
        ];
        return $data;

    }
}
