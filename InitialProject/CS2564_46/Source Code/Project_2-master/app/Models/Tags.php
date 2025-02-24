<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $fillable = ['name'];

    /**
     * ความสัมพันธ์ Many-to-Many กับ Highlights
     */
    public function highlights()
    {
        return $this->belongsToMany(Highlight::class, 'highlight_tags', 'tag_id', 'highlight_id'); // ✅ แก้ชื่อ Pivot Table
    }
}
