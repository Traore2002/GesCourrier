@extends('layouts.app')

@section('title', 'Recherche - SOSUCO')

@section('content')
<div style="background: #f8fafc; min-height: calc(100vh - 100px); padding: 2rem;">
    
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Header SOSUCO -->
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 8px 24px rgba(46, 125, 50, 0.3);">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
            </div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">Recherche de courriers</h1>
            <p style="color: #64748b; font-size: 1rem; margin-top: 0.5rem;">Trouvez rapidement vos courriers par numéro, objet, référence ou date</p>
        </div>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('search.index') }}" style="background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.06); margin-bottom: 2rem; border: 1px solid #e2e8f0;">
            
            <!-- Barre de recherche principale -->
            <div style="position: relative; margin-bottom: 2rem;">
                <svg style="position: absolute; left: 1.5rem; top: 50%; transform: translateY(-50%); width: 22px; height: 22px; stroke: #94a3b8;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                <input type="text" name="objet" value="{{ request('objet') }}" placeholder="Rechercher par objet, numéro, expéditeur, référence..." style="width: 100%; padding: 1.1rem 1.5rem 1.1rem 4rem; border: 2px solid #e2e8f0; border-radius: 14px; font-size: 1rem; outline: none; transition: all 0.3s; font-weight: 500; box-sizing: border-box;" onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 4px rgba(76, 175, 80, 0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
            </div>

            <!-- Filtres avancés -->
            <div style="background: #f8fafc; border-radius: 16px; padding: 1.8rem; border: 1px solid #e2e8f0;">
                <h3 style="font-size: 1.05rem; font-weight: 700; color: #1e293b; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                    Filtres avancés
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
                    
                    <!-- ✅ NOUVEAU : Référence -->
                    <div>
                        <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.6rem; font-size: 0.9rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            Référence
                        </label>
                        <input type="text" name="reference" value="{{ request('reference') }}" placeholder="Ex: REF-2024-001" style="width: 100%; padding: 0.9rem; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; background: white; outline: none; font-weight: 500; transition: all 0.2s; box-sizing: border-box;" onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                    </div>

                    <!-- Type -->
                    <div>
                        <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.6rem; font-size: 0.9rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                            Type
                        </label>
                        <select name="type" style="width: 100%; padding: 0.9rem; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; background: white; outline: none; cursor: pointer; font-weight: 500; transition: all 0.2s; box-sizing: border-box;" onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                            <option value="">Tous les types</option>
                            <option value="arrivee" {{ request('type') == 'arrivee' ? 'selected' : '' }}>Arrivée</option>
                            <option value="depart" {{ request('type') == 'depart' ? 'selected' : '' }}>Départ</option>
                            <option value="interne" {{ request('type') == 'interne' ? 'selected' : '' }}>Interne</option>
                        </select>
                    </div>

                    <!-- Statut -->
                    <div>
                        <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.6rem; font-size: 0.9rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            Statut
                        </label>
                        <select name="statut" style="width: 100%; padding: 0.9rem; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; background: white; outline: none; cursor: pointer; font-weight: 500; transition: all 0.2s; box-sizing: border-box;" onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                            <option value="">Tous les statuts</option>
                            <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="traite" {{ request('statut') == 'traite' ? 'selected' : '' }}>Traité</option>
                            <option value="archive" {{ request('statut') == 'archive' ? 'selected' : '' }}>Archivé</option>
                        </select>
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.6rem; font-size: 0.9rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                            Catégorie
                        </label>
                        <select name="categorie_id" style="width: 100%; padding: 0.9rem; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; background: white; outline: none; cursor: pointer; font-weight: 500; transition: all 0.2s; box-sizing: border-box;" onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('categorie_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date de -->
                    <div>
                        <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.6rem; font-size: 0.9rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            Date de
                        </label>
                        <input type="date" name="date_debut" value="{{ request('date_debut') }}" style="width: 100%; padding: 0.9rem; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; outline: none; font-weight: 500; transition: all 0.2s; box-sizing: border-box;" onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; flex-wrap: wrap;">
                <a href="{{ route('search.index') }}" style="padding: 0.9rem 2rem; border: 2px solid #e2e8f0; background: white; color: #64748b; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: flex; align-items: center; gap: 0.6rem; font-size: 0.95rem;" onmouseover="this.style.borderColor='#94a3b8'; this.style.color='#475569'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'; this.style.transform='translateY(0)'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
                    Réinitialiser
                </a>
                <button type="submit" style="padding: 0.9rem 2.5rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 16px rgba(46, 125, 50, 0.3); transition: all 0.2s; display: flex; align-items: center; gap: 0.6rem; font-size: 0.95rem;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 24px rgba(46, 125, 50, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(46, 125, 50, 0.3)'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                    Rechercher
                </button>
            </div>
        </form>

        <!-- Résultats de recherche -->
        @if(request()->hasAny(['objet', 'reference', 'type', 'statut', 'categorie_id', 'date_debut']))
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <h2 style="font-size: 1.3rem; font-weight: 700; color: #1e293b; margin: 0;">Résultats de la recherche</h2>
            <span style="background: #E8F5E9; color: #2E7D32; padding: 0.5rem 1.2rem; border-radius: 20px; font-weight: 600; font-size: 0.95rem;">{{ $courriers->total() }} résultat(s)</span>
        </div>
        @endif

        <!-- Liste des résultats -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @forelse($courriers as $courrier)
                @php
                    $typeColors = [
                        'arrivee' => ['bg' => '#E8F5E9', 'text' => '#2E7D32', 'border' => '#A5D6A7'],
                        'depart' => ['bg' => '#E3F2FD', 'text' => '#1976D2', 'border' => '#90CAF9'],
                        'interne' => ['bg' => '#FFF3E0', 'text' => '#F57C00', 'border' => '#FFCC80']
                    ];
                    $statutColors = [
                        'en_cours' => ['bg' => '#FFF3E0', 'text' => '#F57C00'],
                        'traite' => ['bg' => '#E8F5E9', 'text' => '#2E7D32'],
                        'archive' => ['bg' => '#F5F5F5', 'text' => '#757575']
                    ];
                    $typeConfig = $typeColors[$courrier->type] ?? $typeColors['interne'];
                    $statutConfig = $statutColors[$courrier->statut] ?? $statutColors['en_cours'];
                    $typeLabel = $courrier->type === 'arrivee' ? 'Arrivée' : ($courrier->type === 'depart' ? 'Départ' : 'Interne');
                    $statutLabel = $courrier->statut === 'en_cours' ? 'En cours' : ($courrier->statut === 'traite' ? 'Traité' : 'Archivé');
                @endphp

                <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-left: 5px solid {{ $typeConfig['border'] }}; transition: all 0.2s;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)'; this.style.transform='translateX(4px)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'; this.style.transform='translateX(0)'">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
                        <div style="flex: 1; min-width: 250px;">
                            <h3 style="font-weight: 700; color: #1e293b; font-size: 1.1rem; margin: 0 0 0.8rem 0;">{{ $courrier->objet }}</h3>
                            <div style="display: flex; gap: 0.8rem; flex-wrap: wrap; align-items: center;">
                                <span style="display: inline-flex; padding: 0.4rem 0.9rem; background: {{ $typeConfig['bg'] }}; color: {{ $typeConfig['text'] }}; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">{{ $typeLabel }}</span>
                                <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">N° {{ $courrier->numero_enregistrement }}</span>
                                
                                {{-- ✅ NOUVEAU : Affichage de la référence si elle existe --}}
                                @if($courrier->reference)
                                    <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">• Réf: {{ $courrier->reference }}</span>
                                @endif

                                @if($courrier->departement)
                                    <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">• {{ $courrier->departement->nom }}</span>
                                @endif
                            </div>
                        </div>
                        <span style="display: inline-flex; padding: 0.4rem 1rem; background: {{ $statutConfig['bg'] }}; color: {{ $statutConfig['text'] }}; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">{{ $statutLabel }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 1rem;">
                        <div style="color: #64748b; font-size: 0.9rem; display: flex; align-items: center; gap: 0.4rem;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            {{ $courrier->created_at->format('d F Y') }}
                        </div>
                        <a href="{{ route('courriers.show', $courrier) }}" style="color: #2E7D32; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: #E8F5E9; border-radius: 10px; transition: all 0.2s;" onmouseover="this.style.background='#2E7D32'; this.style.color='white'" onmouseout="this.style.background='#E8F5E9'; this.style.color='#2E7D32'">
                            Voir détails
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>
                    </div>
                </div>
            @empty
                @if(request()->hasAny(['objet', 'reference', 'type', 'statut', 'categorie_id', 'date_debut']))
                    <div style="background: white; border-radius: 16px; padding: 3rem; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.05);">
                        <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                        </div>
                        <p style="color: #475569; font-size: 1.2rem; font-weight: 700; margin: 0 0 0.5rem 0;">Aucun courrier trouvé</p>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0;">Essayez de modifier vos critères de recherche</p>
                    </div>
                @endif
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