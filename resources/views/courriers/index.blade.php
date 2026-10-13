@extends('layouts.app')

@section('title', 'Courriers en Traitement - SOSUCO')

@section('content')
<div style="background: #f8fafc; min-height: calc(100vh - 100px); padding: 2rem;">
    
    <div style="max-width: 1400px; margin: 0 auto;">
        
        <!-- Header moderne -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">Courriers en Traitement</h1>
                <p style="color: #64748b; font-size: 1rem; margin-top: 0.4rem;">Gérez et suivez tous vos courriers actifs</p>
            </div>
            
            @if(Auth::user()->role !== 'standardiste')
            <!-- ✅ BOUTON MODIFIÉ : Transmet le type actuel (ex: ?type=arrivee) au formulaire de création -->
            <a href="{{ route('courriers.create', request()->only('type')) }}" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.9rem 1.6rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 16px rgba(46, 125, 50, 0.3); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 24px rgba(46, 125, 50, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(46, 125, 50, 0.3)'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Nouveau courrier
            </a>
            @endif
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
                    <div style="width: 44px; height: 44px; background: #E3F2FD; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1976D2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    </div>
                    <div>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #1e293b;">{{ $courriers->where('type', 'arrivee')->count() }}</div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Arrivées</div>
                    </div>
                </div>
            </div>
            <div style="background: white; border-radius: 14px; padding: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 44px; height: 44px; background: #FFF3E0; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#F57C00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #1e293b;">{{ $courriers->where('statut', 'en_attente_reception')->count() }}</div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">En attente</div>
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
        </div>

        <!-- Filtres et recherche -->
        <div style="background: white; border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
            <form method="GET" action="{{ route('courriers.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
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
                    <a href="{{ route('courriers.index') }}" style="padding: 0.75rem 1rem; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #64748b; text-decoration: none; font-weight: 600; display: flex; align-items: center; transition: all 0.2s;" onmouseover="this.style.borderColor='#94a3b8'" onmouseout="this.style.borderColor='#e2e8f0'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
                    </a>
                </div>
            </form>
        </div>

        <!-- Tableau des courriers -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <tr>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">N° Enregistrement</th>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Objet</th>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Département</th>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Date</th>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Statut</th>
                            <th style="padding: 1rem; text-align: center; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courriers as $courrier)
                            @php
                                $typeColors = [
                                    'arrivee' => ['bg' => '#E8F5E9', 'text' => '#2E7D32'],
                                    'depart' => ['bg' => '#E3F2FD', 'text' => '#1976D2'],
                                    'interne' => ['bg' => '#FFF3E0', 'text' => '#F57C00']
                                ];
                                $typeLabels = ['arrivee' => 'Arrivée', 'depart' => 'Départ', 'interne' => 'Interne'];
                                
                                $statutColors = [
                                    'brouillon' => ['bg' => '#F1F5F9', 'text' => '#64748B'],
                                    'en_attente_reception' => ['bg' => '#FFE0B2', 'text' => '#F57C00'],
                                    'receptionne' => ['bg' => '#E3F2FD', 'text' => '#1976D2'],
                                    'en_attente_decision' => ['bg' => '#FFF3E0', 'text' => '#F57C00'],
                                    'en_cours' => ['bg' => '#E3F2FD', 'text' => '#1976D2'],
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
                                $statutConfig = $statutColors[$courrier->statut] ?? $statutColors['en_cours'];
                                $statutLabel = $statutLabels[$courrier->statut] ?? ucfirst(str_replace('_', ' ', $courrier->statut));
                            @endphp
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                                <td style="padding: 1rem; font-weight: 700; color: #1e293b; font-size: 0.95rem;">{{ $courrier->numero_enregistrement }}</td>
                                <td style="padding: 1rem;">
                                    <span style="display: inline-flex; padding: 0.4rem 0.8rem; background: {{ $typeConfig['bg'] }}; color: {{ $typeConfig['text'] }}; border-radius: 16px; font-size: 0.8rem; font-weight: 600;">
                                        {{ $typeLabels[$courrier->type] ?? ucfirst($courrier->type) }}
                                    </span>
                                </td>
                                <td style="padding: 1rem; color: #475569; font-size: 0.95rem;">{{ $courrier->objet }}</td>
                                <td style="padding: 1rem; color: #64748b; font-size: 0.95rem;">{{ $courrier->departement->nom ?? 'Non assigné' }}</td>
                                <td style="padding: 1rem; color: #64748b; font-size: 0.9rem;">{{ $courrier->created_at->format('d/m/Y') }}</td>
                                <td style="padding: 1rem;">
                                    <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.8rem; background: {{ $statutConfig['bg'] }}; color: {{ $statutConfig['text'] }}; border-radius: 16px; font-size: 0.8rem; font-weight: 600;">
                                        <span style="width: 6px; height: 6px; background: {{ $statutConfig['text'] }}; border-radius: 50%;"></span>
                                        {{ $statutLabel }}
                                    </span>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <!-- Bouton Voir -->
                                        <a href="{{ route('courriers.show', $courrier) }}" style="width: 32px; height: 32px; background: #E3F2FD; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; text-decoration: none;" onmouseover="this.style.background='#2196F3'" onmouseout="this.style.background='#E3F2FD'">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2196F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </a>
                                        
                                        <!-- Bouton Modifier -->
                                        @if(Auth::user()->role !== 'standardiste')
                                        <a href="{{ route('courriers.edit', $courrier) }}" style="width: 32px; height: 32px; background: #E8F5E9; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; text-decoration: none;" onmouseover="this.style.background='#4CAF50'" onmouseout="this.style.background='#E8F5E9'">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>
                                        @endif

                                        <!-- Bouton Supprimer (Conditionnel) -->
                                        @if($courrier->canBeDeleted() && (auth()->id() === $courrier->user_id || auth()->user()->role === 'administrateur'))
                                            <form action="{{ route('courriers.destroy', $courrier->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce courrier non envoyé ? Cette action est irréversible.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="width: 32px; height: 32px; background: #FEE2E2; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#DC2626'" onmouseout="this.style.background='#FEE2E2'">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                </button>
                                            </form>
                                        @else
                                            <span style="width: 32px; height: 32px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: not-allowed;" title="Ce courrier a déjà été envoyé dans le circuit et ne peut plus être supprimé.">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 3rem; text-align: center; color: #94a3b8;">
                                    <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                    </div>
                                    <p style="color: #475569; font-size: 1.1rem; font-weight: 700; margin: 0 0 0.5rem 0;">Aucun courrier trouvé</p>
                                    <p style="color: #94a3b8; font-size: 0.95rem; margin: 0;">Commencez par créer un nouveau courrier</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($courriers->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
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