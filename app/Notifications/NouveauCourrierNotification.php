<?php

namespace App\Notifications;

use App\Models\Courrier;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NouveauCourrierNotification extends Notification
{
    use Queueable;

    public $courrier;

    public function __construct(Courrier $courrier)
    {
        $this->courrier = $courrier;
    }

    public function via($notifiable)
    {
        return ['database']; // On enregistre en base de données
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Nouveau courrier N° ' . $this->courrier->numero_enregistrement . ' en attente de distribution.',
            'courrier_id' => $this->courrier->id,
            'type' => 'nouveau_courrier'
        ];
    }
}