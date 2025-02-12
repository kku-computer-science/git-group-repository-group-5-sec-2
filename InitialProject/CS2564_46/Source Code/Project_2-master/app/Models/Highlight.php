<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'picture',
        'isSelected',
        'paper_id'
    ];
    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }
}
