<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'steps',
        'created_by',
        'is_active',
    ];

    // Conversion automatique de la colonne 'steps' en tableau PHP (JSON)
    protected $casts = [
        'steps' => 'array',
        'is_active' => 'boolean',
    ];

    // Relation : Le workflow a été créé par un utilisateur
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}