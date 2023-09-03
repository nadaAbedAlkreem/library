<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model
{
    use HasFactory ,SoftDeletes ;
    protected $fillable = [
        'name', 
        'author',  
        'image',
        'category_id'  
      , 'date_of_publication' 
       ,'details' 
      , 'price'
   
];

public function categories()
{
  return $this->belongsTo('App\Models\Categories',  'category_id' , 'id');
}
}
