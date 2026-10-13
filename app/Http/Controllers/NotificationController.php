<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Marque toutes les notifications de l'utilisateur comme lues
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }

    // Marque une notification spécifique comme lue (utile quand on clique dessus)
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back();
    }
}