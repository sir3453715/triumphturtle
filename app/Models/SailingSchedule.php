<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SailingSchedule extends Model
{
    use HasFactory;
    protected $table = 'sailing_schedule';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'status', 'from_country', 'to_country', 'statement_time', 'parcel_deadline', 'sailing_date', 'arrival_date',
        'on_off', 'price', 'minimum', 'box_interval', 'discount','final_price','min_price'
    ];

    public function fromCountry(){
        return $this->belongsTo(Country::class,'from_country','id');
    }

    public function toCountry(){
        return $this->belongsTo(Country::class,'to_country','id');
    }

}
