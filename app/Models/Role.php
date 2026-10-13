<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'actif',
    ];

    // ⚠️ IMPORTANT : Ne mets PAS 'permissions' => 'array' ici !
    // Nous utilisons maintenant une table pivot, pas une colonne JSON.
    protected $casts = [
        'actif' => 'boolean',
    ];

    /**
     * Un rôle peut avoir plusieurs utilisateurs
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Un rôle peut avoir plusieurs permissions (Relation Plusieurs-à-Plusieurs)
     * Note : On retire ->withTimestamps() car la table pivot 'permission_role' 
     * n'a pas de colonnes created_at/updated_at.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    /**
     * Vérifie si le rôle a une permission spécifique
     */
    public function hasPermission($permissionNom)
    {
        return $this->permissions->contains('nom', $permissionNom);
    }
}