@extends('layouts.app')

@section('title', 'Transmettre en Transit - SOSUCO')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem 1rem;">
    
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('courriers.show', $courrier) }}" style="color: #64748b; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Retour
        </a>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">🚚 Transmission en Mode Transit</h1>
    </div>

    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1.5rem; border-left: 4px solid #8B5CF6;">
        <h3 style="font-size: 1rem; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Courrier N° {{ $courrier->numero_enregistrement }}</h3>
        <p style="color: #64748b; font-size: 0.9rem; margin: 0;">{{ $courrier->objet }}</p>
        <p style="color: #8B5CF6; font-size: 0.85rem; margin-top: 0.5rem; font-weight: 600;">🔄 Ce courrier passera automatiquement en mode "Interne Transit"</p>
    </div>

    <form action="{{ route('courriers.transmettreInterne', $courrier) }}" method="POST" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.5rem;">🏢 Transmettre à (Département / Direction) <span style="color: red;">*</span></label>
            <select name="departement_id" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                <option value="">-- Sélectionner le destinataire --</option>
                @foreach($departements as $dept)
                    @if($dept->id !== Auth::user()->departement_id) {{-- Empêcher de s'envoyer à soi-même --}}
                        <option value="{{ $dept->id }}">{{ $dept->nom }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.5rem;">📝 Note de transmission (Instructions pour le destinataire)</label>
            <textarea name="note_transmission" rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;" placeholder="Ex: Pour validation et signature...">{{ old('note_transmission') }}</textarea>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('courriers.show', $courrier) }}" style="padding: 0.8rem 1.5rem; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; font-weight: 600;">Annuler</a>
            <button type="submit" style="padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                🚚 Confirmer la transmission (Transit)
            </button>
        </div>
    </form>
</div>
@endsection