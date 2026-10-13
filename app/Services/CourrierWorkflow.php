<?php

namespace App\Services;

use App\Models\Courrier;
use App\Models\CourrierHistorique;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class CourrierWorkflow
{
    /**
     * Transition automatique du statut selon l'action
     */
    public static function transition(Courrier $courrier, string $action, array $options = []): bool
    {
        $transitions = [
            'creer' => [
                'from' => null,
                'to' => 'en_attente_reception',
                'message' => 'Courrier créé et affecté à la secrétaire',
            ],
            'receptionner' => [
                'from' => 'en_attente_reception',
                'to' => 'receptionne',
                'message' => 'Courrier réceptionné par la secrétaire',
            ],
            'envoyer_direction' => [
                'from' => 'receptionne',
                'to' => 'en_attente_decision',
                'message' => 'Courrier envoyé au directeur pour décision',
            ],
            'traiter' => [
                'from' => 'en_attente_decision',
                'to' => 'traite',
                'message' => 'Courrier traité par le directeur',
            ],
            'archiver' => [
                'from' => 'traite',
                'to' => 'archive',
                'message' => 'Courrier archivé',
            ],
        ];

        if (!isset($transitions[$action])) {
            return false;
        }

        $transition = $transitions[$action];

        // Vérification : on ne peut faire l'action que si le statut est le bon
        if ($transition['from'] !== null && $courrier->statut !== $transition['from']) {
            return false; // Action non autorisée pour ce statut
        }

        // ✅ TRANSITION AUTOMATIQUE DU STATUT
        $courrier->statut = $transition['to'];
        
        // Champs de dates automatiques selon l'action
        if ($action === 'receptionner') {
            $courrier->date_reception = now();
        }
        if ($action === 'envoyer_direction') {
            $courrier->date_envoi_direction = now();
        }
        if ($action === 'traiter') {
            $courrier->date_traitement = now();
        }

        $courrier->save();

        // Enregistrement dans l'historique (traçabilité automatique)
        CourrierHistorique::create([
            'courrier_id' => $courrier->id,
            'user_id' => Auth::id(),
            'action' => $action,
            'ancien_statut' => $transition['from'],
            'nouveau_statut' => $transition['to'],
            'commentaire' => $options['commentaire'] ?? $transition['message'],
        ]);

        return true;
    }

    /**
     * Vérifie si une action est autorisée pour l'utilisateur actuel
     */
    public static function canPerform(Courrier $courrier, string $action): bool
    {
        $user = Auth::user();
        
        $rules = [
            'creer' => in_array($user->role, ['standardiste', 'secretaire']),
            'receptionner' => $user->role === 'secretaire' && $courrier->statut === 'en_attente_reception',
            'envoyer_direction' => $user->role === 'secretaire' && $courrier->statut === 'receptionne',
            'traiter' => $user->role === 'directeur' && $courrier->statut === 'en_attente_decision',
            'archiver' => $user->role === 'administrateur' && $courrier->statut === 'traite',
        ];

        return $rules[$action] ?? false;
    }
}