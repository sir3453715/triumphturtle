<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $table = 'warehouse';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country','img','title','phone','address','link','notes'
    ];

    public function countryTitle(){
        return $this->belongsTo(Country::class,'country');
    }
}
