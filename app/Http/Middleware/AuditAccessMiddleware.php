<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;

class AuditAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // On laisse la requête passer et on récupère la réponse
        $response = $next($request);

        // Si la réponse est une interdiction (403), on la logue !
        if ($response->getStatusCode() === 403) {
            AuditLog::logAction(
                'access_denied', 
                'Tentative d\'accès non autorisé à : ' . $request->url()
            );
        }

        return $response;
    }
}