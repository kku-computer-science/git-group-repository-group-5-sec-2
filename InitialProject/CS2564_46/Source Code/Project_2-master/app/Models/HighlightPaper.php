<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighlightPaper extends Model
{
    use HasFactory;

    public function paper()
    {
        return $this->belongsTo(Paper::class, 'paper_id');
    }
}
