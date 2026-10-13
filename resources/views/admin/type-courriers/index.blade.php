@extends('layouts.app')

@section('title', 'Types de Courriers - SOSUCO')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
    
    <!-- En-tête -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 700; color: #1e293b; margin: 0;">Types de Courriers</h1>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 0.3rem;">Liste des types disponibles avec leurs préfixes</p>
        </div>
        <a href="{{ route('admin.type-courriers.create') }}" style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; padding: 0.8rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3); display: flex; align-items: center; gap: 0.5rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Nouveau Type
        </a>
    </div>

    <!-- ✅ Message de succès (Vert) -->
    @if(session('success'))
        <div style="background: #C8E6C9; color: #1B5E20; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border-left: 4px solid #2E7D32; display: flex; align-items: center; gap: 0.8rem;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- ✅ Message d'avertissement (Orange) pour la désactivation -->
    @if(session('warning'))
        <div style="background: #FEF3C7; border: 2px solid #F59E0B; color: #92400E; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.8rem;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            <span style="font-weight: 600;">{!! session('warning') !!}</span>
        </div>
    @endif

    <!-- Tableau des types -->
    <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); border-bottom: 2px solid #4CAF50;">
                    <tr>
                        <th style="padding: 1.2rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #2E7D32; text-transform: uppercase;">Préfixe</th>
                        <th style="padding: 1.2rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #2E7D32; text-transform: uppercase;">Nom du Type</th>
                        <th style="padding: 1.2rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #2E7D32; text-transform: uppercase;">Description</th>
                        <th style="padding: 1.2rem; text-align: center; font-size: 0.85rem; font-weight: 700; color: #2E7D32; text-transform: uppercase;">Statut</th>
                        <th style="padding: 1.2rem; text-align: center; font-size: 0.85rem; font-weight: 700; color: #2E7D32; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            <td style="padding: 1.2rem;">
                                <span style="display: inline-flex; padding: 0.5rem 1rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border-radius: 8px; font-weight: 700; font-size: 0.9rem; letter-spacing: 0.5px;">
                                    {{ strtoupper($type->prefixe) }} {{-- ✅ CORRIGÉ : prefixe au lieu de prefix --}}
                                </span>
                            </td>
                            <td style="padding: 1.2rem; font-weight: 600; color: #1e293b;">
                                {{ ucfirst($type->nom) }}
                            </td>
                            <td style="padding: 1.2rem; color: #64748b;">
                                {{ $type->description ?: 'Aucune description' }}
                            </td>
                            <td style="padding: 1.2rem; text-align: center;">
                                <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.8rem; background: {{ $type->actif ? '#E8F5E9' : '#FEE2E2' }}; color: {{ $type->actif ? '#2E7D32' : '#DC2626' }}; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                    <span style="width: 7px; height: 7px; background: {{ $type->actif ? '#2E7D32' : '#DC2626' }}; border-radius: 50%;"></span>
                                    {{ $type->actif ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td style="padding: 1.2rem; text-align: center;">
                                <form action="{{ route('admin.type-courriers.destroy', $type->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('⚠️ Attention : Si ce type est déjà utilisé dans l\'historique des courriers, il sera automatiquement DÉSACTIVÉ au lieu d\'être supprimé pour préserver l\'intégrité des données. Continuer ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding: 0.5rem 1rem; background: #FEE2E2; color: #DC2626; border: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s;" 
                                            onmouseover="this.style.background='#DC2626'; this.style.color='white'" 
                                            onmouseout="this.style.background='#FEE2E2'; this.style.color='#DC2626'">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        Supprimer / Désactiver
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem; text-align: center; color: #94a3b8;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1rem; opacity: 0.5;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                <p>Aucun type de courrier défini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Information importante mise à jour -->
    <div style="margin-top: 1.5rem; padding: 1.2rem; background: #E3F2FD; border-left: 4px solid #1976D2; border-radius: 8px;">
        <p style="color: #1565C0; margin: 0; font-size: 0.9rem;">
            <strong>💡 Information :</strong> Les préfixes sont utilisés pour générer automatiquement les numéros de courrier. Si vous tentez de supprimer un type déjà utilisé dans l'historique, le système le <strong>désactivera automatiquement</strong> (au lieu de le supprimer) pour préserver l'intégrité et la traçabilité de vos données.
        </p>
    </div>
</div>
@endsection