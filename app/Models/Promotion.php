<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['image', 'name', 'description', 'price'];

    public function users()
    {
    	return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function scopePromotions($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
