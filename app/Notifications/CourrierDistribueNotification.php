<?php

namespace App\Notifications;

use App\Models\Courrier;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CourrierDistribueNotification extends Notification
{
    use Queueable;

    public $courrier;

    public function __construct(Courrier $courrier)
    {
        $this->courrier = $courrier;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Le courrier N° ' . $this->courrier->numero_enregistrement . ' a été distribué à votre département.',
            'courrier_id' => $this->courrier->id,
            'type' => 'courrier_distribue'
        ];
    }
}