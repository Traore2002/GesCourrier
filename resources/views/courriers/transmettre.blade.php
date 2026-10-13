@extends('layouts.app')

@section('title', 'Transmettre le Courrier - SOSUCO')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem 1rem;">
    
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('courriers.show', $courrier) }}" style="color: #64748b; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Retour
        </a>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">📡 Transmission du Courrier</h1>
    </div>

    @if ($errors->any())
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1.5rem; border-left: 4px solid #1976D2;">
        <h3 style="font-size: 1rem; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Courrier N° {{ $courrier->numero_enregistrement }}</h3>
        <p style="color: #64748b; font-size: 0.9rem; margin: 0;">{{ $courrier->objet }}</p>
    </div>

    <form action="{{ route('courriers.transmettre', $courrier) }}" method="POST" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.5rem;">🏢 Département destinataire <span style="color: red;">*</span></label>
            <select name="departement_id" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                <option value="">-- Sélectionner un département --</option>
                @foreach($departements as $dept)
                    <option value="{{ $dept->id }}" {{ old('departement_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nom }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.5rem;">📝 Note de transmission (optionnel)</label>
            <textarea name="note_transmission" rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;" placeholder="Instructions ou commentaires pour le département destinataire...">{{ old('note_transmission') }}</textarea>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('courriers.show', $courrier) }}" style="padding: 0.8rem 1.5rem; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; font-weight: 600;">Annuler</a>
            <button type="submit" style="padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #1976D2 0%, #2196F3 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                 Transmettre au département
            </button>
        </div>
    </form>
</div>
@endsection