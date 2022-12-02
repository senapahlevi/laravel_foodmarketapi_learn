<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
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

     
     public function toArray(){ //these accessor format camelcase and used for to make picturePath is not error , but if using picture_path you do not used these function(ngakalin)
        $toArray = parent::toArray();
        $toArray['picturePath'] = $this->picturePath;
        return $toArray ; // used for epoch unix timestamp ex: 1601234 => become 11-june 2020 to readable for humans 
    }
    public function getPictureAtAttribute(){ //these accessor format camelcase 
        return url('').Storage::url($this->attributes['picturePath']); // used for upload image using these format for full get url,coz default laravel isnot full get url
    }
}
