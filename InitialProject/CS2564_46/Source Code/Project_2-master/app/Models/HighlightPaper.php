<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighlightPaper extends Model
{
    use HasFactory;


    public function getPictureAttribute($value){
        if($value){
            return asset('images/highlight_images/'.$value);
        }else{
            return asset('images/highlight_images/no-image.png');
        }
    }

    public function paper()
    {
        return $this->belongsTo(Paper::class, 'paper_id');
    }
}
