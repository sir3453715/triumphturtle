<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    protected $table = 'calendar';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "title","member","start_time","end_time", "description","color"
    ];

    public function user(){
        return $this->belongsTo(User::class,'id','member');
    }
    public function get_title_with_member(){
        $title = $this->title;
        switch ($this->member){
            case 'no':
                $title .= '';
                break;
            case 'all':
                $title .= ' - 所有人';
                break;
            default:
                $user = User::find($this->member);
                $title .= ' - '.$user->name;
                break;
        }
        return $title;

    }
}
