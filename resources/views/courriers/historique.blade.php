@extends('layouts.app')

@section('title', 'Historique des Courriers - SOSUCO')

@section('content')
<div style="background: #f8fafc; min-height: calc(100vh - 100px); padding: 2rem;">
    
    <div style="max-width: 1400px; margin: 0 auto;">
        
        <!-- Header épuré -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">Historique des Courriers</h1>
                <p style="color: #64748b; font-size: 1rem; margin-top: 0.4rem;">Archive complète et traçabilité de tous vos courriers</p>
            </div>
            <a href="{{ route('courriers.index') }}" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: white; border: 1px solid #e2e8f0; border-radius: 12px; color: #475569; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.04);" onmouseover="this.style.borderColor='#2E7D32'; this.style.color='#2E7D32'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.15)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#475569'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Retour à la liste
            </a>
        </div>

        <!-- Statistiques rapides -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div style="background: white; border-radius: 14px; padding: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 44px; height: 44px; background: #E8F5E9; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    </div>
                    <div>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #1e293b;">{{ $courriers->total() }}</div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Total courriers</div>
                    </div>
                </div>
            </div>
            <div style="background: white; border-radius: 14px; padding: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 44px; height: 44px; background: #E8F5E9; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #1e293b;">{{ $courriers->where('statut', 'traite')->count() }}</div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Traités</div>
                    </div>
                </div>
            </div>
            <div style="background: white; border-radius: 14px; padding: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 44px; height: 44px; background: #FFF3E0; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#F57C00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #1e293b;">{{ $courriers->whereIn('statut', ['en_cours', 'en_attente_reception', 'receptionne', 'en_attente_decision'])->count() }}</div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">En cours / En attente</div>
                    </div>
                </div>
            </div>
            <div style="background: white; border-radius: 14px; padding: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 44px; height: 44px; background: #F5F5F5; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#757575" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8v13H3V8"></path><path d="M1 3h22v5H1z"></path><path d="M10 12h4"></path></svg>
                    </div>
                    <div>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #1e293b;">{{ $courriers->where('statut', 'archive')->count() }}</div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Archivés</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres modernes -->
        <form method="GET" action="{{ route('courriers.historique') }}" style="background: white; border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
                <div>
                    <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.85rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" style="margin-right: 0.4rem;"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                        Recherche
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Objet, numéro, référence..." style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div>
                    <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.85rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" style="margin-right: 0.4rem;"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Type
                    </label>
                    <select name="type" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; background: white; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
                        <option value="">Tous les types</option>
                        <option value="arrivee" {{ request('type') == 'arrivee' ? 'selected' : '' }}>Arrivée</option>
                        <option value="depart" {{ request('type') == 'depart' ? 'selected' : '' }}>Départ</option>
                        <option value="interne" {{ request('type') == 'interne' ? 'selected' : '' }}>Interne</option>
                    </select>
                </div>
                <div>
                    <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.85rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" style="margin-right: 0.4rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        Statut
                    </label>
                    <select name="statut" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; background: white; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente_reception" {{ request('statut') == 'en_attente_reception' ? 'selected' : '' }}>En attente de réception</option>
                        <option value="receptionne" {{ request('statut') == 'receptionne' ? 'selected' : '' }}>Réceptionné</option>
                        <option value="en_attente_decision" {{ request('statut') == 'en_attente_decision' ? 'selected' : '' }}>En attente de décision</option>
                        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="traite" {{ request('statut') == 'traite' ? 'selected' : '' }}>Traité</option>
                        <option value="archive" {{ request('statut') == 'archive' ? 'selected' : '' }}>Archivé</option>
                    </select>
                </div>
                <div style="display: flex; gap: 0.6rem;">
                    <button type="submit" style="flex: 1; padding: 0.75rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem; font-size: 0.9rem; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                        Filtrer
                    </button>
                    <a href="{{ route('courriers.historique') }}" style="padding: 0.75rem 1rem; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #64748b; text-decoration: none; font-weight: 600; display: flex; align-items: center; transition: all 0.2s;" onmouseover="this.style.borderColor='#94a3b8'" onmouseout="this.style.borderColor='#e2e8f0'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
                    </a>
                </div>
            </div>
        </form>

        <!-- Timeline des courriers -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            @php
                $groupedCourriers = $courriers->groupBy(function($courrier) {
                    return $courrier->created_at->format('Y-m-d');
                });
            @endphp

            @forelse($groupedCourriers as $date => $courriersDuJour)
                <div>
                    <!-- En-tête de date -->
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 1.2rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);">
                            {{ \Carbon\Carbon::parse($date)->format('d') }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: #1e293b; font-size: 1.1rem;">
                                {{ \Carbon\Carbon::parse($date)->isoFormat('dddd D MMMM YYYY') }}
                            </div>
                            <div style="color: #64748b; font-size: 0.85rem;">
                                {{ $courriersDuJour->count() }} courrier{{ $courriersDuJour->count() > 1 ? 's' : '' }}
                            </div>
                        </div>
                        <div style="width: 40px; height: 2px; background: #e2e8f0;"></div>
                    </div>

                    <!-- Liste des courriers du jour -->
                    <div style="display: flex; flex-direction: column; gap: 0.8rem; padding-left: 1rem;">
                        @foreach($courriersDuJour as $courrier)
                            @php
                                $typeColors = [
                                    'arrivee' => ['bg' => '#E8F5E9', 'text' => '#2E7D32', 'border' => '#A5D6A7', 'icon' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line>'],
                                    'depart' => ['bg' => '#E3F2FD', 'text' => '#1976D2', 'border' => '#90CAF9', 'icon' => '<path d="M22 2L11 13"></path><path d="M22 2l-7 20-4-9-9-4 20-7z"></path>'],
                                    'interne' => ['bg' => '#FFF3E0', 'text' => '#F57C00', 'border' => '#FFCC80', 'icon' => '<path d="M17 1l4 4-4 4"></path><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><path d="M7 23l-4-4 4-4"></path><path d="M21 13v2a4 4 0 0 1-4 4H3"></path>']
                                ];
                                $typeLabels = ['arrivee' => 'Arrivée', 'depart' => 'Départ', 'interne' => 'Interne'];
                                
                                // ✅ AJOUT DE TOUS LES NOUVEAUX STATUTS DU WORKFLOW
                                $statutColors = [
                                    'brouillon' => ['bg' => '#F1F5F9', 'text' => '#64748B'],
                                    'en_attente_reception' => ['bg' => '#FFE0B2', 'text' => '#F57C00'],
                                    'receptionne' => ['bg' => '#E3F2FD', 'text' => '#1976D2'],
                                    'en_attente_decision' => ['bg' => '#FFF3E0', 'text' => '#F57C00'],
                                    'en_cours' => ['bg' => '#FFF3E0', 'text' => '#F57C00'],
                                    'traite' => ['bg' => '#E8F5E9', 'text' => '#2E7D32'],
                                    'archive' => ['bg' => '#F5F5F5', 'text' => '#757575']
                                ];
                                $statutLabels = [
                                    'brouillon' => 'Brouillon',
                                    'en_attente_reception' => 'En attente de réception',
                                    'receptionne' => 'Réceptionné',
                                    'en_attente_decision' => 'En attente de décision',
                                    'en_cours' => 'En cours',
                                    'traite' => 'Traité',
                                    'archive' => 'Archivé'
                                ];
                                
                                $typeConfig = $typeColors[$courrier->type] ?? $typeColors['interne'];
                                $statutConfig = $statutColors[$courrier->statut] ?? $statutColors['brouillon'];
                                $statutLabel = $statutLabels[$courrier->statut] ?? ucfirst(str_replace('_', ' ', $courrier->statut));
                            @endphp
                            
                            <div style="display: flex; gap: 1rem; padding: 1.3rem; background: white; border-radius: 14px; border-left: 5px solid {{ $typeConfig['border'] }}; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.3s;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)'; this.style.transform='translateX(6px)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'; this.style.transform='translateX(0)'">
                                <!-- Heure -->
                                <div style="min-width: 75px; text-align: center; padding: 0.6rem; background: #f8fafc; border-radius: 10px; font-weight: 700; color: #475569; font-size: 0.95rem; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e2e8f0;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" style="margin-bottom: 0.3rem;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    {{ $courrier->created_at->format('H:i') }}
                                </div>

                                <!-- Contenu -->
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.6rem; flex-wrap: wrap; gap: 0.5rem;">
                                        <h3 style="font-weight: 700; color: #1e293b; font-size: 1.05rem; margin: 0; line-height: 1.4;">{{ $courrier->objet }}</h3>
                                        <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.8rem; background: {{ $typeConfig['bg'] }}; color: {{ $typeConfig['text'] }}; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">{!! $typeConfig['icon'] !!}</svg>
                                            {{ $typeLabels[$courrier->type] }}
                                        </span>
                                    </div>
                                    
                                    <div style="display: flex; gap: 1.2rem; flex-wrap: wrap; margin-bottom: 0.8rem;">
                                        <div style="display: flex; align-items: center; gap: 0.4rem; color: #64748b; font-size: 0.85rem; font-weight: 500;">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                            {{ $courrier->numero_enregistrement }}
                                        </div>
                                        @if($courrier->departement)
                                        <div style="display: flex; align-items: center; gap: 0.4rem; color: #64748b; font-size: 0.85rem; font-weight: 500;">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l8-4 8 4v14M8 21v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4"></path></svg>
                                            {{ $courrier->departement->nom }}
                                        </div>
                                        @endif
                                    </div>

                                    <div style="display: flex; gap: 0.8rem; align-items: center; flex-wrap: wrap;">
                                        <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.8rem; background: {{ $statutConfig['bg'] }}; color: {{ $statutConfig['text'] }}; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                                            <span style="width: 7px; height: 7px; background: {{ $statutConfig['text'] }}; border-radius: 50%;"></span>
                                            {{ $statutLabel }}
                                        </span>
                                        <a href="{{ route('courriers.show', $courrier) }}" style="color: #2E7D32; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 0.3rem; padding: 0.4rem 0.8rem; background: #E8F5E9; border-radius: 8px; transition: all 0.2s;" onmouseover="this.style.background='#2E7D32'; this.style.color='white'" onmouseout="this.style.background='#E8F5E9'; this.style.color='#2E7D32'">
                                            Voir détails
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div style="background: white; border-radius: 20px; padding: 4rem 2rem; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
                        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    </div>
                    <h3 style="color: #1e293b; font-size: 1.3rem; font-weight: 700; margin: 0 0 0.8rem 0;">Aucun courrier dans l'historique</h3>
                    <p style="color: #64748b; font-size: 1rem; margin: 0; max-width: 500px; margin-left: auto; margin-right: auto; line-height: 1.6;">Les courriers enregistrés apparaîtront ici automatiquement</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($courriers->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 2.5rem;">
            {{ $courriers->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .pagination { display: flex; gap: 0.3rem; list-style: none; padding: 0; margin: 0; }
    .pagination li { display: inline; }
    .pagination a, .pagination span { 
        padding: 0.6rem 0.9rem; 
        border: 1px solid #e2e8f0; 
        border-radius: 8px; 
        text-decoration: none; 
        color: #64748b; 
        font-size: 0.9rem;
        background: white;
        transition: all 0.2s;
    }
    .pagination a:hover { background: #2E7D32; border-color: #2E7D32; color: white; }
    .pagination .active span { background: #2E7D32; border-color: #2E7D32; color: white; font-weight: 600; }
    .pagination .disabled span { opacity: 0.5; cursor: not-allowed; }
</style>
@endsection