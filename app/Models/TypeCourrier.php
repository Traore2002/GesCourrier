<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCourrier extends Model
{
    use HasFactory;

    // On précise le nom de la table pour être sûr à 100%
    protected $table = 'type_courriers';

    protected $fillable = [
        'nom',
        'prefixe',
        'description',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];
}