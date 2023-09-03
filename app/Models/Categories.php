<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory , SoftDeletes ;
    protected $fillable = [
        'name', 
        'image',  
        'image',
        'active'  
  
];
public function books()
{
 return $this->hasMany( 'App\Models\books', 'category_id' , 'id');
}


}
