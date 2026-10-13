@extends('layouts.app')

@section('title', 'Tableau de bord - SN-SOSUCO')

@section('content')
<div style="padding: 0;">
    
    <!-- En-tête -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="color: #1e293b; font-size: 1.8rem; font-weight: 700; margin: 0;">Tableau de bord</h1>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 0.3rem;">
                {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }} • Bienvenue {{ $user->prenom }}
                @if(!$isAdmin && $user->departement)
                    <span style="color: #2E7D32; font-weight: 600;">({{ $user->departement->nom }})</span>
                @endif
            </p>
        </div>
        <div style="display: flex; gap: 0.8rem;">
            <a href="{{ route('courriers.create') }}" style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; padding: 0.7rem 1.3rem; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3); display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Nouveau courrier
            </a>
        </div>
    </div>

    <!-- CARTES DE STATISTIQUES -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
        
        <!-- Total Courriers -->
        <div style="background: linear-gradient(135deg, #2E7D32 0%, #43A047 100%); border-radius: 20px; padding: 1.5rem; color: white; box-shadow: 0 8px 24px rgba(46, 125, 50, 0.25); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; position: relative;">
                <div style="background: rgba(255,255,255,0.2); padding: 0.6rem; border-radius: 12px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                </div>
                <span style="background: rgba(255,255,255,0.25); padding: 0.3rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                    {{ $tauxEvolution >= 0 ? '+' : '' }}{{ $tauxEvolution }}%
                </span>
            </div>
            <div style="position: relative;">
                <p style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 0.3rem;">Total Courriers</p>
                <h2 style="font-size: 2rem; font-weight: 700; margin: 0;">{{ number_format($totalCourriers) }}</h2>
                <p style="font-size: 0.75rem; opacity: 0.85; margin-top: 0.5rem;">
                    @if($isAdmin) Courriers vs mois dernier @else De votre département @endif
                </p>
            </div>
        </div>

        <!-- En cours -->
        <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div style="background: #FFF3E0; padding: 0.6rem; border-radius: 12px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#F57C00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <span style="background: #FFF3E0; color: #E65100; padding: 0.3rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">En cours</span>
            </div>
            <div>
                <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.3rem;">En traitement</p>
                <h2 style="font-size: 2rem; font-weight: 700; color: #1e293b; margin: 0;">{{ number_format($enCours) }}</h2>
                <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.5rem;">Courriers en attente</p>
            </div>
        </div>

        <!-- Traités -->
        <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div style="background: #E8F5E9; padding: 0.6rem; border-radius: 12px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <span style="background: #E8F5E9; color: #2E7D32; padding: 0.3rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                    +{{ $totalCourriers > 0 ? round(($traites/$totalCourriers)*100, 1) : 0 }}%
                </span>
            </div>
            <div>
                <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.3rem;">Traités</p>
                <h2 style="font-size: 2rem; font-weight: 700; color: #1e293b; margin: 0;">{{ number_format($traites) }}</h2>
                <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.5rem;">Courriers finalisés</p>
            </div>
        </div>

        <!-- Utilisateurs actifs (UNIQUEMENT POUR ADMIN) -->
        @if($isAdmin)
        <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div style="background: #E3F2FD; padding: 0.6rem; border-radius: 12px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <span style="background: #E3F2FD; color: #1976D2; padding: 0.3rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Actifs</span>
            </div>
            <div>
                <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.3rem;">Utilisateurs</p>
                <h2 style="font-size: 2rem; font-weight: 700; color: #1e293b; margin: 0;">{{ $utilisateursActifs }}</h2>
                <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.5rem;">Sur {{ $totalUtilisateurs }} au total</p>
            </div>
        </div>
        @endif
    </div>

    <!-- GRAPHIQUES -->
    <!-- La grille s'adapte : 2 colonnes pour admin, 1 seule pour les autres -->
    <div style="display: grid; grid-template-columns: {{ $isAdmin ? '2fr 1fr' : '1fr' }}; gap: 1.2rem; margin-bottom: 2rem;">
        
        <!-- Graphique barres : Courriers par mois -->
        <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div>
                    <h3 style="color: #1e293b; font-size: 1.1rem; font-weight: 700; margin: 0;">Évolution des courriers</h3>
                    <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.2rem;">
                        @if($isAdmin) 6 derniers mois (tous départements) @else 6 derniers mois (votre département) @endif
                    </p>
                </div>
            </div>

            <div style="display: flex; align-items: flex-end; justify-content: space-between; height: 220px; gap: 0.8rem; padding: 0 0.5rem;">
                @php 
                    $totals = array_column($courriersParMois, 'total');
                    $maxMois = !empty($totals) ? max($totals) : 1;
                    if ($maxMois == 0) $maxMois = 1; 
                @endphp
                
                @foreach($courriersParMois as $index => $mois)
                    @php $hauteur = ($mois['total'] / $maxMois) * 100; @endphp
                    <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 0.75rem; font-weight: 600; color: #1e293b;">{{ $mois['total'] }}</span>
                        <div style="width: 100%; max-width: 50px; height: {{ $hauteur }}%; background: {{ $index === count($courriersParMois) - 1 ? 'linear-gradient(180deg, #2E7D32 0%, #4CAF50 100%)' : 'linear-gradient(180deg, #A5D6A7 0%, #C8E6C9 100%)' }}; border-radius: 8px 8px 4px 4px; transition: all 0.3s; min-height: 4px;"></div>
                        <span style="font-size: 0.75rem; color: #64748b; font-weight: 500;">{{ $mois['mois'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Répartition par type (Donut) - UNIQUEMENT POUR ADMIN -->
        @if($isAdmin)
        <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
            <div style="margin-bottom: 1.5rem;">
                <h3 style="color: #1e293b; font-size: 1.1rem; font-weight: 700; margin: 0;">Par type</h3>
                <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.2rem;">Répartition globale</p>
            </div>

            @php
                $totalTypes = array_sum($courriersParType);
                $colors = ['#2E7D32', '#4CAF50', '#81C784', '#A5D6A7'];
                $typeLabels = ['arrivee' => 'Arrivée', 'depart' => 'Départ', 'interne' => 'Interne'];
            @endphp

            <div style="display: flex; justify-content: center; margin-bottom: 1.5rem;">
                <svg width="160" height="160" viewBox="0 0 160 160">
                    @php
                        $offset = 0; $radius = 60; $circumference = 2 * M_PI * $radius;
                    @endphp
                    @foreach($courriersParType as $type => $count)
                        @php
                            $percentage = $totalTypes > 0 ? $count / $totalTypes : 0;
                            $strokeDash = $percentage * $circumference;
                            $strokeGap = $circumference - $strokeDash;
                            $rotation = ($offset / $totalTypes) * 360 - 90;
                            $color = $colors[array_search($type, array_keys($courriersParType)) % count($colors)];
                            $offset += $count;
                        @endphp
                        <circle cx="80" cy="80" r="{{ $radius }}" fill="none" stroke="{{ $color }}" stroke-width="20" 
                                stroke-dasharray="{{ $strokeDash }} {{ $strokeGap }}" transform="rotate({{ $rotation }} 80 80)"></circle>
                    @endforeach
                    <text x="80" y="75" text-anchor="middle" style="font-size: 1.5rem; font-weight: 700; fill: #1e293b;">{{ $totalTypes }}</text>
                    <text x="80" y="95" text-anchor="middle" style="font-size: 0.7rem; fill: #64748b;">Total</text>
                </svg>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.7rem;">
                @foreach($courriersParType as $type => $count)
                    @php
                        $percentage = $totalTypes > 0 ? round(($count / $totalTypes) * 100, 1) : 0;
                        $color = $colors[array_search($type, array_keys($courriersParType)) % count($colors)];
                        $label = $typeLabels[$type] ?? ucfirst($type);
                    @endphp
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem; background: #f8fafc; border-radius: 10px;">
                        <div style="display: flex; align-items: center; gap: 0.6rem;">
                            <div style="width: 10px; height: 10px; background: {{ $color }}; border-radius: 50%;"></div>
                            <span style="font-size: 0.85rem; color: #475569; font-weight: 500;">{{ $label }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.8rem;">
                            <span style="font-size: 0.85rem; font-weight: 700; color: #1e293b;">{{ $count }}</span>
                            <span style="font-size: 0.75rem; color: #2E7D32; font-weight: 600; background: #E8F5E9; padding: 0.2rem 0.5rem; border-radius: 10px;">{{ $percentage }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- LISTES : Top départements (ADMIN) & Derniers courriers -->
    <!-- La grille s'adapte : 2 colonnes pour admin, 1 seule pour les autres -->
    <div style="display: grid; grid-template-columns: {{ $isAdmin ? '1fr 1fr' : '1fr' }}; gap: 1.2rem;">
        
        <!-- Top départements - UNIQUEMENT POUR ADMIN -->
        @if($isAdmin)
        <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div>
                    <h3 style="color: #1e293b; font-size: 1.1rem; font-weight: 700; margin: 0;">Top Départements</h3>
                    <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.2rem;">Activité cette année</p>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($topDepartements as $index => $dept)
                    @php
                        $maxDept = $topDepartements->first()->courriers_count ?: 1;
                        $progress = ($dept->courriers_count / $maxDept) * 100;
                        $deptColors = ['#2E7D32', '#4CAF50', '#81C784', '#A5D6A7', '#C8E6C9'];
                    @endphp
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                            <div style="display: flex; align-items: center; gap: 0.7rem;">
                                <div style="width: 36px; height: 36px; background: {{ $deptColors[$index % 5] }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.9rem;">
                                    {{ substr($dept->nom, 0, 1) }}
                                </div>
                                <div>
                                    <p style="font-size: 0.9rem; font-weight: 600; color: #1e293b; margin: 0;">{{ $dept->nom }}</p>
                                    <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">{{ $dept->courriers_count }} courriers</p>
                                </div>
                            </div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #2E7D32;">{{ round($progress) }}%</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                            <div style="width: {{ $progress }}%; height: 100%; background: linear-gradient(90deg, #2E7D32 0%, #4CAF50 100%); border-radius: 10px; transition: width 0.5s;"></div>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: #94a3b8; padding: 2rem;">Aucun département enregistré</p>
                @endforelse
            </div>
        </div>
        @endif

        <!-- Derniers courriers -->
        <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div>
                    <h3 style="color: #1e293b; font-size: 1.1rem; font-weight: 700; margin: 0;">Derniers courriers</h3>
                    <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.2rem;">
                        @if($isAdmin) Activité récente (tous départements) @else Activité récente (votre département) @endif
                    </p>
                </div>
                <a href="{{ route('courriers.historique') }}" style="font-size: 0.8rem; color: #2E7D32; text-decoration: none; font-weight: 600;">Voir tout →</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                @forelse($derniersCourriers as $courrier)
                    @php
                        $typeColors = ['arrivee' => '#2E7D32', 'depart' => '#1976D2', 'interne' => '#F57C00'];
                        $statutColors = ['en_cours' => '#F57C00', 'traite' => '#2E7D32', 'archive' => '#64748b'];
                        $statutLabels = ['en_cours' => 'En cours', 'traite' => 'Traité', 'archive' => 'Archivé'];
                    @endphp
                    <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem; background: #f8fafc; border-radius: 12px; transition: all 0.2s;" onmouseover="this.style.background='#F1F8E9'" onmouseout="this.style.background='#f8fafc'">
                        <div style="width: 40px; height: 40px; background: {{ $typeColors[$courrier->type] ?? '#94a3b8' }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <p style="font-size: 0.85rem; font-weight: 600; color: #1e293b; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $courrier->objet }}</p>
                            <p style="font-size: 0.75rem; color: #94a3b8; margin: 0.2rem 0 0 0;">{{ $courrier->numero_enregistrement }} • {{ $courrier->created_at->diffForHumans() }}</p>
                        </div>
                        <span style="font-size: 0.7rem; font-weight: 600; color: {{ $statutColors[$courrier->statut] ?? '#94a3b8' }}; background: {{ $statutColors[$courrier->statut] ?? '#94a3b8' }}15; padding: 0.3rem 0.6rem; border-radius: 12px; white-space: nowrap;">
                            {{ $statutLabels[$courrier->statut] ?? $courrier->statut }}
                        </span>
                    </div>
                @empty
                    <p style="text-align: center; color: #94a3b8; padding: 2rem;">Aucun courrier enregistré</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

<style>
    @media (max-width: 900px) {
        div[style*="grid-template-columns: 2fr 1fr"],
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection