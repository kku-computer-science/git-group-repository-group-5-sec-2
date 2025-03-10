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
    
    //filter highlight by tags
    public function filteredHighlights(array $filterTags)
    {
        $tagIds = self::whereIn('name', $filterTags)->pluck('id')->toArray();

        //filter using OR logic
        /*return Highlight::whereHas('tags', function ($query) use ($tagIds) {
            $query->whereIn('tags.id', $tagIds);
        })->get();*/

        //filter using AND logic
        return Highlight::whereHas('tags', function ($query) use ($tagIds) {
            $query->whereIn('tags.id', $tagIds);
        }, '=', count($tagIds))->get();

    }
}
