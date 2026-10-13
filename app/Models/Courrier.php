<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_enregistrement',
        'type',
        'sous_type',
        'objet',
        'reference',
        'expediteur',
        'destinataire',
        
        // Champs Arrivée
        'date_arrivee',
        'heure_arrivee',
        'date_courrier_expediteur',
        'type_document',
        'nombre_pieces_jointes',
        'necessite_reponse',
        'priorite',
        
        // Champs Départ & Signataire
        'destinataire_nom_fonction',
        'destinataire_structure',
        'destinataire_ville_adresse',
        'signataire_nom',
        'signataire_fonction',
        'mode_expedition',
        'transmis_standardiste',
        
        // ✅ NOUVEAUX : Champs Transmission & Expédition Physique
        'date_transmission',
        'priorite_envoi',
        'mode_envoi_effectif',
        'date_envoi_physique',
        'numero_suivi',
        
        // ✅ NOUVEAUX : Champs Suivi Accusé de Réception (AR)
        'ar_recu',
        'date_reception_ar',
        'fichier_ar',
        'accuse_reception_date', // Conservé pour compatibilité si utilisé ailleurs
        
        // Champs Workflow & Liaison
        'courrier_arrive_lie_id',
        
        // Champs Généraux
        'date_reception',
        'heure_reception',
        'date_envoi',
        'heure_envoi',
        'date_enregistrement',
        'heure_enregistrement',
        'date_validation',
        'heure_validation',
        'statut',
        'contenu',
        'fichier_scanne',
        'user_id',
        'departement_id',
        'categorie_id',
    ];

    protected $casts = [
        'date_reception' => 'date',
        'date_envoi' => 'date',
        'date_enregistrement' => 'date',
        'date_validation' => 'date',
        'date_arrivee' => 'date',
        'date_courrier_expediteur' => 'date',
        'date_envoi_effectif' => 'date',
        'accuse_reception_date' => 'date',
        
        // ✅ NOUVEAUX CASTS POUR LES DATES ET BOOLÉENS
        'date_transmission' => 'date',
        'date_envoi_physique' => 'date',
        'date_reception_ar' => 'date',
        
        'transmis_standardiste' => 'boolean',
        'necessite_reponse' => 'boolean',
        'ar_recu' => 'boolean',
    ];

    /* ==========================================
     * RELATIONS
     * ========================================== */
    public function user() { return $this->belongsTo(User::class); }
    public function departement() { return $this->belongsTo(Departement::class); }
    public function categorie() { return $this->belongsTo(Categorie::class); }

    /**
     * Lien vers le courrier arrivé d'origine (pour le courrier départ lié)
     */
    public function courrierArriveLie()
    {
        return $this->belongsTo(Courrier::class, 'courrier_arrive_lie_id');
    }

    /* ==========================================
     * SCOPES
     * ========================================== */
    public function scopeType($query, $type) { return $query->where('type', $type); }
    public function scopeSousType($query, $sousType) { return $query->where('sous_type', $sousType); }
    public function scopeStatut($query, $statut) { return $query->where('statut', $statut); }
    public function scopeUrgent($query) { return $query->where('priorite', 'urgent'); }

    /* ==========================================
     * ACCESSEURS (Libellés avec Emojis Modernes)
     * ========================================== */
    public function getTypeLabelAttribute()
    {
        $types = ['arrivee' => '📥 Arrivée', 'depart' => '📤 Départ', 'interne' => '🔄 Interne'];
        return $types[$this->type] ?? ucfirst($this->type);
    }

    public function getSousTypeLabelAttribute()
    {
        $sousTypes = ['initie' => '✍️ Initié', 'transit' => '🚚 Transit'];
        return $sousTypes[$this->sous_type] ?? ucfirst($this->sous_type ?? '');
    }

    public function getStatutLabelAttribute()
    {
        $statuts = [
            'en_attente_reception' => '⏳ En attente de réception',
            'enregistre'           => '📋 Enregistré',
            'transmis'             => '📡 Transmis',
            'pris_en_charge'       => '🤝 Pris en charge',
            'redige'               => '🖋️ Rédigé',
            'valide'               => '🟢 Validé',
            'transmis_standardiste'=> '📬 Transmis à la standardiste',
            'envoye'               => '📤 Envoyé',
            'traite'               => '💼 Traité',
            'cloture'              => '🔒 Clôturé',
            'archive'              => '🗄️ Archivé',
        ];
        return $statuts[$this->statut] ?? ucfirst(str_replace('_', ' ', $this->statut));
    }

    public function getPrioriteLabelAttribute()
    {
        return $this->priorite === 'urgent' ? '🔴 Urgent' : '🟢 Normal';
    }

    /* ==========================================
     * MÉTHODES MÉTIER
     * ========================================== */
    public function canBeDeleted()
    {
        $deletableStatuses = ['en_attente_reception', 'enregistre', 'brouillon', 'redige'];
        return in_array($this->statut, $deletableStatuses);
    }
}