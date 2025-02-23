<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasFactory;
    
    protected $table = 'highlights';

    // ✅ เพิ่มฟิลด์ที่อนุญาตให้บันทึกได้
    protected $fillable = [
        'title',
        'detail',
        'cover_image',
        'creator',
        'active'  // ต้องมี active ด้วย
    ];

     /**
     * ความสัมพันธ์ Many-to-Many กับ Tags
     */
    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'highlight_tags', 'highlight_id', 'tag_id'); // ✅ แก้ชื่อ Pivot Table
    }

    public function images()
    {
        return $this->hasMany(images::class, 'highlight_id');
    }

    public function getImageAttribute($value){
        if($value){
            return asset('images/highlight/'.$value);
        }else{
            return asset('images/highlight/no-image.png');
        }
    }
}
