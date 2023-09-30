<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'testimonial', 'rating', 'user_id'];

    // Definir la relación con el usuario (paciente)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
