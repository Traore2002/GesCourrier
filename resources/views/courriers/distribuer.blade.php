@extends('layouts.app')

@section('title', 'Distribuer le Courrier - SN-SOSUCO')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); max-width: 700px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="color: #e65100; margin: 0;">📦 Distribuer le Courrier</h2>
        <a href="{{ route('courriers.index') }}" style="color: #64748b; text-decoration: none; font-weight: 600;">← Retour à la liste</a>
    </div>

    <!-- Résumé du courrier -->
    <div style="background: #fff3e0; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; border-left: 4px solid #e65100;">
        <p style="margin: 0 0 0.3rem 0; font-size: 0.9rem; color: #e65100; font-weight: 600;">N° {{ $courrier->numero_enregistrement }}</p>
        <p style="margin: 0 0 0.3rem 0; font-size: 1.1rem; font-weight: 700; color: #333;">{{ $courrier->objet }}</p>
        <p style="margin: 0; font-size: 0.9rem; color: #666;">
            Expéditeur : <strong>{{ $courrier->expediteur }}</strong> | Type : <strong>{{ ucfirst($courrier->type) }}</strong>
        </p>
    </div>

    <form action="{{ route('courriers.traiterDistribution', $courrier) }}" method="POST">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: #333; font-size: 1.1rem;">🏢 Choisir le Secrétariat / Département destinataire *</label>
            <select name="departement_id" required style="width: 100%; padding: 0.8rem; border: 2px solid #e65100; border-radius: 6px; font-size: 1rem; font-weight: 600;">
                <option value="">-- Sélectionner le département --</option>
                @foreach($departements as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->nom }} ({{ $dept->code }})</option>
                @endforeach
            </select>
            @error('departement_id') <span style="color: #e74c3c; font-size: 0.85rem;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">📝 Note de distribution (optionnel)</label>
            <textarea name="note_distribution" rows="3" placeholder="Ex: Urgent, à traiter avant vendredi..." style="width: 100%; padding: 0.7rem; border: 1px solid #cbd5e1; border-radius: 6px; resize: vertical;"></textarea>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('courriers.index') }}" style="padding: 0.7rem 1.5rem; border: 1px solid #cbd5e1; border-radius: 6px; text-decoration: none; color: #475569; font-weight: 600;">Annuler</a>
            <button type="submit" style="padding: 0.7rem 1.5rem; background: #e65100; color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 1rem;">
                📤 Envoyer au département
            </button>
        </div>
    </form>
</div>
@endsection