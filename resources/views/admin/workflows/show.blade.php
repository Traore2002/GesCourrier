@extends('layouts.app')

@section('title', 'Détails du Workflow - SN-SOSUCO')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1rem;">
    
    <!-- En-tête avec bouton retour -->
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.workflows.index') }}" style="display: flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-weight: 500; padding: 0.5rem 1rem; background: white; border-radius: 8px; border: 1px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Retour à la liste
        </a>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">Détails du Workflow</h1>
    </div>

    <!-- Carte principale -->
    <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1);">
        
        <!-- Informations générales -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #f1f5f9;">
            <div>
                <h2 style="font-size: 1.8rem; font-weight: 700; color: #2E7D32; margin: 0 0 0.5rem 0;">{{ $workflow->name }}</h2>
                <p style="color: #64748b; line-height: 1.6;">{{ $workflow->description ?: 'Aucune description fournie.' }}</p>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; font-weight: 600; color: #94a3b8; text-transform: uppercase;">Type de courrier</span>
                    <p style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin: 0.3rem 0 0 0; text-transform: capitalize;">{{ $workflow->type }}</p>
                </div>
                <div>
                    <span style="font-size: 0.8rem; font-weight: 600; color: #94a3b8; text-transform: uppercase;">Statut</span>
                    <p style="margin: 0.3rem 0 0 0;">
                        <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.3rem 0.8rem; background: {{ $workflow->is_active ? '#E8F5E9' : '#FEE2E2' }}; color: {{ $workflow->is_active ? '#2E7D32' : '#DC2626' }}; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">
                            <span style="width: 7px; height: 7px; background: {{ $workflow->is_active ? '#2E7D32' : '#DC2626' }}; border-radius: 50%;"></span>
                            {{ $workflow->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </p>
                </div>
                <div>
                    <span style="font-size: 0.8rem; font-weight: 600; color: #94a3b8; text-transform: uppercase;">Créé par</span>
                    <p style="font-size: 1rem; color: #1e293b; margin: 0.3rem 0 0 0;">{{ $workflow->creator ? $workflow->creator->prenom . ' ' . $workflow->creator->nom : 'Système' }}</p>
                </div>
            </div>
        </div>

        <!-- Liste des étapes -->
        <h3 style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
            Étapes du processus ({{ is_array($workflow->steps) ? count($workflow->steps) : 0 }})
        </h3>

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @if(is_array($workflow->steps) && count($workflow->steps) > 0)
                @foreach($workflow->steps as $index => $step)
                    <div style="display: flex; gap: 1rem; align-items: flex-start; padding: 1.2rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.1rem; flex-shrink: 0;">
                            {{ $step['order'] ?? ($index + 1) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <h4 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; text-transform: capitalize;">
                                    {{ str_replace('_', ' ', $step['type']) }}
                                </h4>
                                @if(!empty($step['deadline_hours']))
                                    <span style="font-size: 0.8rem; font-weight: 600; color: #F57C00; background: #FFF3E0; padding: 0.2rem 0.6rem; border-radius: 20px;">
                                        ⏱️ {{ $step['deadline_hours'] }}h max
                                    </span>
                                @endif
                            </div>
                            @if(!empty($step['description']))
                                <p style="color: #64748b; font-size: 0.9rem; margin: 0 0 0.5rem 0;">{{ $step['description'] }}</p>
                            @endif
                            @if(!empty($step['role_id']))
                                @php
                                    $role = \App\Models\Role::find($step['role_id']);
                                @endphp
                                <span style="font-size: 0.85rem; color: #2E7D32; font-weight: 500; background: #E8F5E9; padding: 0.3rem 0.8rem; border-radius: 8px; display: inline-block;">
                                    👤 Rôle requis : {{ $role ? ucfirst($role->nom) : 'Inconnu' }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p style="color: #94a3b8; text-align: center; padding: 2rem; font-style: italic;">Aucune étape définie pour ce workflow.</p>
            @endif
        </div>

    </div>
</div>
@endsection