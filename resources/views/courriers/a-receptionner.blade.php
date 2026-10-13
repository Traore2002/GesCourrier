@extends('layouts.app')

@section('title', 'Courriers à Réceptionner - SOSUCO')

@section('content')
<div style="background: #f8fafc; min-height: calc(100vh - 100px); padding: 2rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0;">📥 Courriers à Réceptionner</h1>
                <p style="color: #64748b; font-size: 1rem; margin-top: 0.4rem;">Liste des courriers distribués à votre département en attente de votre validation.</p>
            </div>
            <a href="{{ route('courriers.index') }}" style="padding: 0.8rem 1.5rem; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #64748b; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Retour à tous les courriers
            </a>
        </div>

        <!-- Tableau -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #FFF3E0; border-bottom: 2px solid #F57C00;">
                    <tr>
                        <th style="padding: 1rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #E65100; text-transform: uppercase;">N° Enregistrement</th>
                        <th style="padding: 1rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #E65100; text-transform: uppercase;">Objet</th>
                        <th style="padding: 1rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #E65100; text-transform: uppercase;">Expéditeur</th>
                        <th style="padding: 1rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #E65100; text-transform: uppercase;">Date de distribution</th>
                        <th style="padding: 1rem; text-align: center; font-size: 0.85rem; font-weight: 700; color: #E65100; text-transform: uppercase;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courriers as $courrier)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#fffbeb'" onmouseout="this.style.background='white'">
                            <td style="padding: 1rem; font-weight: 700; color: #1e293b;">{{ $courrier->numero_enregistrement }}</td>
                            <td style="padding: 1rem; color: #475569;">{{ $courrier->objet }}</td>
                            <td style="padding: 1rem; color: #64748b;">{{ $courrier->expediteur ?? 'Non spécifié' }}</td>
                            <td style="padding: 1rem; color: #64748b;">{{ $courrier->created_at->format('d/m/Y à H:i') }}</td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <!-- Bouton Voir -->
                                    <a href="{{ route('courriers.show', $courrier) }}" style="padding: 0.5rem 1rem; background: #E3F2FD; color: #1976D2; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.3rem;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        Voir
                                    </a>
                                    
                                    <!-- ✅ Bouton Réceptionner (Action principale) -->
                                    <form action="{{ route('courriers.receptionner', $courrier) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; gap: 0.3rem; box-shadow: 0 2px 8px rgba(46, 125, 50, 0.3);" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            Réceptionner
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem; text-align: center; color: #94a3b8;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1rem; opacity: 0.5;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                <p style="font-size: 1.1rem; font-weight: 600; color: #475569;">Aucun courrier en attente de réception</p>
                                <p style="font-size: 0.9rem;">Vous avez traité tous les courriers de votre département !</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($courriers->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            {{ $courriers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection