@extends('layouts.app')

@section('title', 'Rôles et Permissions - SOSUCO')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
    
    <!-- En-tête -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0;">Rôles et Permissions</h1>
            <p style="color: #64748b; font-size: 0.95rem; margin-top: 0.4rem;">Gérez les accès et les autorisations de chaque profil utilisateur.</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(46, 125, 50, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.3)'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Nouveau rôle
        </a>
    </div>

    <!-- Tableau des rôles -->
    <div style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <tr>
                    <th style="padding: 1.2rem 1.5rem; text-align: left; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Nom du rôle</th>
                    <th style="padding: 1.2rem 1.5rem; text-align: left; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Description</th>
                    <th style="padding: 1.2rem 1.5rem; text-align: left; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Permissions</th>
                    <th style="padding: 1.2rem 1.5rem; text-align: center; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                        <td style="padding: 1.2rem 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.8rem;">
                                <div style="width: 36px; height: 36px; background: {{ $role->nom === 'administrateur' ? '#FEE2E2' : '#E8F5E9' }}; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $role->nom === 'administrateur' ? '#DC2626' : '#2E7D32' }}" stroke-width="2">
                                        @if($role->nom === 'administrateur')
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        @else
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>
                                        @endif
                                    </svg>
                                </div>
                                <span style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">{{ ucfirst($role->nom) }}</span>
                                @if(!$role->actif)
                                    <span style="padding: 0.2rem 0.6rem; background: #F1F5F9; color: #64748B; border-radius: 12px; font-size: 0.7rem; font-weight: 600;">Inactif</span>
                                @endif
                            </div>
                        </td>
                        <td style="padding: 1.2rem 1.5rem; color: #64748b; font-size: 0.9rem; max-width: 300px;">
                            {{ $role->description ?: 'Aucune description' }}
                        </td>
                        <td style="padding: 1.2rem 1.5rem;">
                            <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                                @foreach($role->permissions->take(3) as $perm)
                                    <span style="padding: 0.3rem 0.7rem; background: #E8F5E9; color: #2E7D32; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                                        {{ $perm->label }}
                                    </span>
                                @endforeach
                                @if($role->permissions->count() > 3)
                                    <span style="padding: 0.3rem 0.7rem; background: #F1F5F9; color: #64748B; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                                        +{{ $role->permissions->count() - 3 }} autres
                                    </span>
                                @endif
                                @if($role->permissions->count() === 0)
                                    <span style="color: #94a3b8; font-size: 0.8rem; font-style: italic;">Aucune permission</span>
                                @endif
                            </div>
                        </td>
                        <td style="padding: 1.2rem 1.5rem; text-align: center;">
                            <!-- ✅ SEUL LE BOUTON MODIFIER EST CONSERVÉ -->
                            <a href="{{ route('admin.roles.edit', $role->id) }}" 
                               style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.2rem; background: #E8F5E9; color: #2E7D32; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.85rem; transition: all 0.2s;" 
                               onmouseover="this.style.background='#2E7D32'; this.style.color='white'" 
                               onmouseout="this.style.background='#E8F5E9'; this.style.color='#2E7D32'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Modifier
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 3rem; text-align: center; color: #94a3b8;">
                            <p style="font-size: 1rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Aucun rôle trouvé</p>
                            <p style="font-size: 0.9rem;">Commencez par créer un nouveau rôle.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection