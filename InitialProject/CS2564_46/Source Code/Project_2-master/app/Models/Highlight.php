<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasFactory;

    protected $table = 'highlight';
    
    public function getImageAttribute($value){
        if($value){
            return asset('images/highlight/'.$value);
        }else{
            return asset('images/highlight/no-image.png');
        }
    }
}
