<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        // Seul l'administrateur peut voir les logs
        if (Auth::user()->role !== 'administrateur') {
            abort(403, 'Accès non autorisé.');
        }

        $query = AuditLog::with('user');

        // Filtres optionnels
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(50);
        $users = User::all();

        return view('admin.audit.index', compact('logs', 'users'));
    }
}