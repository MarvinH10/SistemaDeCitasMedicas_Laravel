<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBlog extends Model
{
    protected $fillable = ['blog_id', 'vistas', 'comentarios'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
