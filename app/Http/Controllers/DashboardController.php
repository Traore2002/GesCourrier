<?php

namespace App\Http\Controllers;

use App\Models\Courrier;
use App\Models\Departement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = ($user->role === 'administrateur');

        // Requête de base pour les courriers
        $courrierQuery = Courrier::query();

        // Si l'utilisateur n'est pas admin, filtrer strictement par son département
        if (!$isAdmin && $user->departement_id) {
            $courrierQuery->where('departement_id', $user->departement_id);
        } elseif (!$isAdmin && !$user->departement_id) {
            $courrierQuery->where('id', 0);
        }

        // 1. Statistiques
        $totalCourriers = (clone $courrierQuery)->count();
        $enCours = (clone $courrierQuery)->where('statut', 'en_cours')->count();
        $traites = (clone $courrierQuery)->where('statut', 'traite')->count();
        $archives = (clone $courrierQuery)->where('statut', 'archive')->count();

        $totalMoisDernier = (clone $courrierQuery)->where('created_at', '<', now()->startOfMonth())->count();
        $tauxEvolution = $totalMoisDernier > 0 ? round((($totalCourriers - $totalMoisDernier) / $totalMoisDernier) * 100, 1) : 0;

        // 2. Courriers par type
        $courriersParType = (clone $courrierQuery)
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type')
            ->toArray();

        // 3. Courriers par mois
        $courriersParMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $mois = now()->subMonths($i);
            $count = (clone $courrierQuery)
                ->whereYear('created_at', $mois->year)
                ->whereMonth('created_at', $mois->month)
                ->count();
            $courriersParMois[] = ['mois' => $mois->format('M'), 'total' => $count];
        }

        // 4. Top départements (UNIQUEMENT ADMIN)
        $topDepartements = collect();
        if ($isAdmin) {
            $topDepartements = Departement::withCount(['courriers' => function ($query) {
                $query->whereYear('created_at', now()->year);
            }])->orderByDesc('courriers_count')->take(5)->get();
        }

        // 5. Derniers courriers
        $derniersCourriers = (clone $courrierQuery)
            ->with(['user', 'departement'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 6. Stats utilisateurs (UNIQUEMENT ADMIN)
        $totalUtilisateurs = $isAdmin ? User::count() : 0;
        $utilisateursActifs = $isAdmin ? User::where('is_active', true)->count() : 0;

        return view('dashboard', compact(
            'totalCourriers', 'enCours', 'traites', 'archives',
            'tauxEvolution', 'courriersParType', 'courriersParMois',
            'topDepartements', 'derniersCourriers',
            'totalUtilisateurs', 'utilisateursActifs', 'user', 'isAdmin'
        ));
    }
}