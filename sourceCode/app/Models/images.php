<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class images extends Model
{
    use HasFactory;
    protected $table = 'images';

    // ✅ เพิ่ม highlight_id เพื่ออนุญาตให้บันทึกได้
    protected $fillable = ['highlight_id', 'image_path'];

    public function highlight()
    {
        return $this->belongsTo(Highlight::class, 'highlight_id');
    }
}
