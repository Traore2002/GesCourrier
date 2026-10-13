<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les champs qu'on autorise à remplir en masse (Mass Assignment)
     */
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'email',
        'password',
        'role', // Conservé par sécurité pour l'ancienne colonne
        'departement_id',
        'is_active',
    ];

    /**
     * Les champs qu'on cache quand on convertit le modèle en JSON/API
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les casts (conversions automatiques de type)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /* ==========================================
     * RELATIONS
     * ========================================== */

    /**
     * Un utilisateur peut avoir plusieurs rôles (Relation Plusieurs-à-Plusieurs)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Un utilisateur appartient à un département
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    /**
     * Un utilisateur a créé plusieurs courriers (via la colonne user_id)
     */
    public function courriers()
    {
        return $this->hasMany(Courrier::class, 'user_id'); 
    }

    /* ==========================================
     * MÉTHODES UTILITAIRES (Helpers)
     * ========================================== */

    /**
     * Vérifie si l'utilisateur est administrateur
     * (Compatible avec le nouveau système à rôles multiples ET l'ancienne colonne)
     */
    public function isAdmin()
    {
        // 1. Vérifie le nouveau système (relation plusieurs-à-plusieurs)
        if ($this->roles && $this->roles->contains('nom', 'administrateur')) {
            return true;
        }
        
        // 2. Fallback : Vérifie l'ancienne colonne 'role'
        if (isset($this->role) && strtolower($this->role) === 'administrateur') {
            return true;
        }

        return false;
    }

    /**
     * Vérifie si l'utilisateur possède une permission spécifique via l'un de ses rôles.
     * 
     * @param string $permissionNom
     * @return bool
     */
       /**
     * Vérifie si l'utilisateur possède une permission spécifique via l'un de ses rôles.
     * ✅ CORRIGÉ : Plus de bypass admin, tout est basé sur les permissions cochées.
     */
    public function hasPermission(string $permissionNom): bool
    {
        // On parcourt tous les rôles de l'utilisateur
        foreach ($this->roles as $role) {
            // Si le rôle a la permission demandée, on retourne true
            if ($role->hasPermission($permissionNom)) {
                return true;
            }
        }
        
        return false;
    }
}