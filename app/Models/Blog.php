<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'tipo', 'archivo'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function detailBlog()
    {
        return $this->hasOne(DetailBlog::class);
    }

    public function userViews()
    {
        return $this->hasMany(UserView::class);
    }

    public function scopeBlogs($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
