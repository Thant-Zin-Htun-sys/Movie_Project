<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'audience_id', 'movie_id', 'rating'
    ];

    public function movie(){
        return $this->belongsTo(Movie::class);
    }

    public function audience(){
        return $this->belongsTo(Audience::class);
    }
}
