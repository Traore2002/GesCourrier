@extends('layouts.app')

@section('title', 'Workflows - SN-SOSUCO')

@section('content')
<div style="max-width: 1400px; margin: 0 auto; padding: 2rem 1rem;">
    
    <!-- En-tête -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 700; color: #1e293b; margin: 0;">Gestion des Workflows</h1>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 0.3rem;">Configurez les flux de traitement des courriers</p>
        </div>
        <a href="{{ route('admin.workflows.create') }}" style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; padding: 0.8rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3); display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(46, 125, 50, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.3)'">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Nouveau Workflow
        </a>
    </div>

    @if(session('success'))
        <div style="background: #C8E6C9; color: #1B5E20; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border-left: 4px solid #2E7D32; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Liste des workflows -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
        @forelse($workflows as $workflow)
            <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 24px rgba(46, 125, 50, 0.12)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.08)'">
                
                <!-- En-tête de la carte -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div style="flex: 1;">
                        <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem 0;">{{ $workflow->name }}</h3>
                        @if($workflow->description)
                            <p style="color: #64748b; font-size: 0.9rem; margin: 0; line-height: 1.5;">{{ Str::limit($workflow->description, 80) }}</p>
                        @else
                            <p style="color: #94a3b8; font-size: 0.9rem; margin: 0; font-style: italic;">Aucune description</p>
                        @endif
                    </div>
                    <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.9rem; background: {{ $workflow->is_active ? '#E8F5E9' : '#FEE2E2' }}; color: {{ $workflow->is_active ? '#2E7D32' : '#DC2626' }}; border-radius: 20px; font-size: 0.8rem; font-weight: 600; white-space: nowrap;">
                        <span style="width: 7px; height: 7px; background: {{ $workflow->is_active ? '#2E7D32' : '#DC2626' }}; border-radius: 50%;"></span>
                        {{ $workflow->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>

                <!-- Badge du type -->
                <div style="margin-bottom: 1rem;">
                    @php
                        $typeLabels = ['arrivee' => 'Arrivée', 'depart' => 'Départ', 'interne' => 'Interne'];
                        $typeColors = ['arrivee' => '#E3F2FD', 'depart' => '#FFF3E0', 'interne' => '#F3E8FF'];
                        $typeTextColors = ['arrivee' => '#1976D2', 'depart' => '#F57C00', 'interne' => '#7E22CE'];
                    @endphp
                    <span style="display: inline-flex; padding: 0.3rem 0.8rem; background: {{ $typeColors[$workflow->type] ?? '#f1f5f9' }}; color: {{ $typeTextColors[$workflow->type] ?? '#64748b' }}; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                        {{ $typeLabels[$workflow->type] ?? ucfirst($workflow->type) }}
                    </span>
                </div>

                <!-- Visualisation des étapes -->
                <div style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; margin-bottom: 1.2rem; border: 1px solid #e2e8f0;">
                    @php 
                        // Sécurité : on vérifie que c'est bien un tableau avant de compter
                        $stepsCount = is_array($workflow->steps) ? count($workflow->steps) : 0; 
                    @endphp
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.8rem;">
                        <span style="font-size: 0.85rem; font-weight: 600; color: #475569;">Étapes du processus</span>
                        <span style="font-size: 0.85rem; font-weight: 700; color: #2E7D32;">{{ $stepsCount }} étape(s)</span>
                    </div>

                    <!-- Mini diagramme des étapes -->
                    <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                        @for($i = 0; $i < min($stepsCount, 5); $i++)
                            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.85rem;">
                                {{ $i + 1 }}
                            </div>
                            @if($i < min($stepsCount, 5) - 1)
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            @endif
                        @endfor
                        @if($stepsCount > 5)
                            <div style="width: 32px; height: 32px; background: #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 700; font-size: 0.85rem;">
                                +{{ $stepsCount - 5 }}
                            </div>
                        @endif
                        @if($stepsCount === 0)
                            <span style="font-size: 0.85rem; color: #94a3b8; font-style: italic;">Aucune étape définie</span>
                        @endif
                    </div>
                </div>

                <!-- Footer de la carte -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                    <span style="font-size: 0.8rem; color: #94a3b8;">
                        Créé par {{ $workflow->creator ? $workflow->creator->prenom . ' ' . $workflow->creator->nom : 'Système' }}
                    </span>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.workflows.show', $workflow->id) }}" style="width: 32px; height: 32px; background: #E3F2FD; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#1976D2'" onmouseout="this.style.background='#E3F2FD'">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="transition: all 0.2s;" onmouseover="this.style.stroke='white'" onmouseout="this.style.stroke='#1976D2'"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                        <form action="{{ route('admin.workflows.destroy', $workflow->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce workflow ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="width: 32px; height: 32px; background: #FEE2E2; border: none; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#DC2626'" onmouseout="this.style.background='#FEE2E2'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="transition: all 0.2s;" onmouseover="this.style.stroke='white'" onmouseout="this.style.stroke='#DC2626'"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: white; border-radius: 16px; border: 2px dashed #e2e8f0;">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin: 0 auto 1rem;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <h3 style="font-size: 1.2rem; font-weight: 600; color: #475569; margin: 0 0 0.5rem 0;">Aucun workflow configuré</h3>
                <p style="color: #94a3b8; margin: 0 0 1.5rem 0;">Commencez par créer votre premier flux de travail.</p>
                <a href="{{ route('admin.workflows.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #2E7D32; color: white; padding: 0.7rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 600;">
                    Créer un workflow
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection