<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActionLog extends Model
{
    use HasFactory;
    protected $table = 'action_log';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','action_table','change_column','action'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function create_log( $model=null , $action='update' ){
        if($action == 'update'){
            $new_array=$model->getDirty();
            $old_array = array();
            foreach ($new_array as $key=>$value){
                $old_array["old_{$key}"]=$model->getOriginal($key);
            }
            $change_column = json_encode(array_merge($old_array,$new_array));
        }else{
            $change_column = json_encode($model->toArray());
        }
         $data=[
            'user_id'=>Auth::id(),
            'action_table'=>get_class($model),
            'change_column'=>$change_column,
            'action'=>$action,
        ];
        ActionLog::create($data);
    }

}
