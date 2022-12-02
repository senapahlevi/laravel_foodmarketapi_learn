<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'ingredients',
        'price',
        'rate',
        'types',
        'picturePath' //these are not recommend,most like laravel to easly without error is (picture_path) but these from frontend side 
     ];

     public function food(){
        return $this->hasOne(Food::class,'id','food_id'); //ini foreign key id, field nya user_id
     }
     public function user(){
        return $this->hasOne(User::class,'id','user_id'); 
     }

     public function getCreatedAtAttribute($value)
     {
         return Carbon::parse($value)->timestamp;
     }
     public function getUpdatedAtAttribute($value)
     {
         return Carbon::parse($value)->timestamp;
     }

}
