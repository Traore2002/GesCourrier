@extends('layouts.app')

@section('title', 'Journal d\'Audit - SN-SOSUCO')

@section('content')
<div style="background: #f8fafc; min-height: calc(100vh - 100px); padding: 2rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">Journal d'Audit</h1>
                <p style="color: #64748b; font-size: 0.95rem; margin-top: 0.3rem;">Historique complet des actions du système</p>
            </div>
            <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.2rem; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #475569; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s;" onmouseover="this.style.borderColor='#2E7D32'; this.style.color='#2E7D32'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#475569'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Dashboard
            </a>
        </div>

        <!-- Statistiques -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div style="background: white; border-radius: 14px; padding: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 44px; height: 44px; background: #E8F5E9; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #1e293b;">{{ $logs->total() }}</div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Total des actions</div>
                    </div>
                </div>
            </div>
            <div style="background: white; border-radius: 14px; padding: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 44px; height: 44px; background: #FFF3E0; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#F57C00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #1e293b;">{{ $logs->where('action', 'access_denied')->count() }}</div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Accès refusés</div>
                    </div>
                </div>
            </div>
            <div style="background: white; border-radius: 14px; padding: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 44px; height: 44px; background: #E8F5E9; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #1e293b;">{{ $logs->where('action', 'create')->count() }}</div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Créations</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <form method="GET" action="{{ route('admin.audit.index') }}" style="background: white; border-radius: 14px; padding: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
                <div>
                    <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.85rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" style="margin-right: 0.4rem;"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Type d'action
                    </label>
                    <select name="action" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; background: white; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
                        <option value="">Toutes les actions</option>
                        <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Création</option>
                        <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Modification</option>
                        <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Suppression</option>
                        <option value="distribute" {{ request('action') == 'distribute' ? 'selected' : '' }}>Distribution</option>
                        <option value="access_denied" {{ request('action') == 'access_denied' ? 'selected' : '' }}>Accès refusé</option>
                    </select>
                </div>
                <div>
                    <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.85rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" style="margin-right: 0.4rem;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        Date de début
                    </label>
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div>
                    <label style="display: flex; align-items: center; font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.85rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" style="margin-right: 0.4rem;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Utilisateur
                    </label>
                    <input type="text" name="user" value="{{ request('user') }}" placeholder="Nom d'utilisateur..." style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div style="display: flex; gap: 0.6rem;">
                    <button type="submit" style="flex: 1; padding: 0.75rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem; font-size: 0.9rem; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                        Filtrer
                    </button>
                    <a href="{{ route('admin.audit.index') }}" style="padding: 0.75rem 1rem; background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: #64748b; text-decoration: none; font-weight: 600; display: flex; align-items: center; transition: all 0.2s;" onmouseover="this.style.borderColor='#94a3b8'" onmouseout="this.style.borderColor='#e2e8f0'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
                    </a>
                </div>
            </div>
        </form>

        <!-- Liste des logs -->
        <div style="background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; overflow: hidden;">
            
            @forelse($logs as $log)
                @php
                    $actionConfig = [
                        'create' => ['icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="15" x2="12" y2="9"></line><line x1="9" y1="12" x2="15" y2="12"></line>', 'bg' => '#E8F5E9', 'text' => '#2E7D32', 'border' => '#A5D6A7', 'label' => 'Création'],
                        'update' => ['icon' => '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>', 'bg' => '#E3F2FD', 'text' => '#1976D2', 'border' => '#90CAF9', 'label' => 'Modification'],
                        'delete' => ['icon' => '<polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>', 'bg' => '#FFEBEE', 'text' => '#C62828', 'border' => '#EF9A9A', 'label' => 'Suppression'],
                        'distribute' => ['icon' => '<polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path>', 'bg' => '#FFF3E0', 'text' => '#F57C00', 'border' => '#FFCC80', 'label' => 'Distribution'],
                        'access_denied' => ['icon' => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path><line x1="12" y1="15" x2="12" y2="15"></line>', 'bg' => '#FCE4EC', 'text' => '#C2185B', 'border' => '#F48FB1', 'label' => 'Accès refusé']
                    ];
                    $config = $actionConfig[$log->action] ?? $actionConfig['update'];
                @endphp

                <div style="display: flex; gap: 1.2rem; padding: 1.3rem 1.5rem; border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                    <!-- Icône d'action -->
                    <div style="width: 44px; height: 44px; min-width: 44px; background: {{ $config['bg'] }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid {{ $config['border'] }};">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="{{ $config['text'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $config['icon'] !!}</svg>
                    </div>

                    <!-- Contenu -->
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem; flex-wrap: wrap; margin-bottom: 0.4rem;">
                            <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
                                <span style="display: inline-flex; padding: 0.3rem 0.7rem; background: {{ $config['bg'] }}; color: {{ $config['text'] }}; border-radius: 16px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.3px;">{{ $config['label'] }}</span>
                                <span style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">{{ $log->user->prenom ?? 'Système' }} {{ $log->user->nom ?? '' }}</span>
                            </div>
                            <span style="color: #94a3b8; font-size: 0.8rem; display: flex; align-items: center; gap: 0.3rem; white-space: nowrap;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                        <p style="color: #475569; font-size: 0.9rem; margin: 0; line-height: 1.5;">{{ $log->description }}</p>
                    </div>
                </div>
            @empty
                <div style="padding: 4rem 2rem; text-align: center;">
                    <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    </div>
                    <p style="color: #475569; font-size: 1.1rem; font-weight: 700; margin: 0 0 0.5rem 0;">Aucune action enregistrée</p>
                    <p style="color: #94a3b8; font-size: 0.9rem; margin: 0;">Les actions du système apparaîtront ici</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            {{ $logs->links() }}
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