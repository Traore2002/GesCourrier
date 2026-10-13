@extends('layouts.app')

@section('title', 'Utilisateurs - SOSUCO')

@section('content')
<div style="background: #f8fafc; min-height: calc(100vh - 100px); padding: 2rem;">
    
    <!-- Header -->
    <div style="max-width: 1400px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 700; color: #1e293b; margin: 0;">Utilisateurs</h1>
                <p style="color: #64748b; font-size: 0.9rem; margin-top: 0.3rem;">Gérez les accès, les rôles et les départements</p>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <!-- ✅ BOUTON NOUVEL UTILISATEUR -->
                <a href="{{ route('admin.users.create') }}" style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; padding: 0.8rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3); display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(46, 125, 50, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.3)'">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Nouvel utilisateur
                </a>

                <a href="{{ route('dashboard') }}" style="background: white; color: #2E7D32; padding: 0.8rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; display: flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Retour au Dashboard
                </a>
            </div>
        </div>

        <!-- Filtres -->
        <form action="{{ route('admin.users.index') }}" method="GET" style="background: white; border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <div style="position: relative; flex: 1; min-width: 250px;">
                <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; stroke: #94a3b8;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                <input type="text" name="search" placeholder="Rechercher par nom, email..." value="{{ request('search') }}" style="width: 100%; padding: 0.7rem 1rem 0.7rem 3rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <select name="role_filter" style="padding: 0.7rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; background: white; outline: none;">
                <option value="">Tous les rôles</option>
                <option value="administrateur" {{ request('role_filter') == 'administrateur' ? 'selected' : '' }}>Administrateur</option>
                <option value="secretaire" {{ request('role_filter') == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                <option value="chef_service" {{ request('role_filter') == 'chef_service' ? 'selected' : '' }}>Chef de service</option>
                <option value="agent" {{ request('role_filter') == 'agent' ? 'selected' : '' }}>Agent</option>
            </select>
            <button type="submit" style="padding: 0.7rem 1.5rem; background: #2E7D32; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Filtrer</button>
        </form>

        <!-- Tableau -->
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <tr>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Matricule</th>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Utilisateur</th>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Rôle</th>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Département</th>
                            <th style="padding: 1rem; text-align: left; font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Statut</th>
                            <th style="padding: 1rem; text-align: center; font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            @php
                                // ✅ CORRECTION MAJEURE : On lit les rôles depuis la relation 'roles' (table pivot)
                                $roleNames = $user->roles->pluck('nom')->map(function($name) {
                                    return ucfirst($name);
                                })->join(', ');
                                
                                $roleName = $roleNames ?: 'Aucun rôle';
                                
                                // Pour la couleur du badge, on se base sur le premier rôle de la liste
                                $firstRole = $user->roles->first();
                                $baseRoleName = $firstRole ? strtolower($firstRole->nom) : 'inconnu';
                                
                                $roleColors = match($baseRoleName) {
                                    'administrateur' => ['bg' => '#E8F5E9', 'text' => '#2E7D32'],
                                    'directeur' => ['bg' => '#E3F2FD', 'text' => '#1976D2'],
                                    'chef_service' => ['bg' => '#F3E8FF', 'text' => '#7E22CE'],
                                    default => ['bg' => '#FFF3E0', 'text' => '#F57C00']
                                };
                            @endphp
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                                <td style="padding: 1rem; font-weight: 600; color: #1e293b;">{{ $user->matricule ?? 'N/A' }}</td>
                                <td style="padding: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.9rem;">
                                            {{ strtoupper(substr($user->prenom ?? 'U', 0, 1) . substr($user->nom ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 600; color: #1e293b;">{{ $user->prenom }} {{ $user->nom }}</div>
                                            <div style="font-size: 0.85rem; color: #64748b;">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- ✅ COLONNE RÔLE CORRIGÉE -->
                                <td style="padding: 1rem;">
                                    <span style="display: inline-flex; padding: 0.4rem 0.8rem; background: {{ $roleColors['bg'] }}; color: {{ $roleColors['text'] }}; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                        {{ $roleName }}
                                    </span>
                                </td>
                                
                                <td style="padding: 1rem; color: #64748b;">{{ $user->departement->nom ?? 'Non assigné' }}</td>
                                <td style="padding: 1rem;">
                                    <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.8rem; background: {{ $user->is_active ? '#E8F5E9' : '#FEE2E2' }}; color: {{ $user->is_active ? '#2E7D32' : '#DC2626' }}; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                        <span style="width: 6px; height: 6px; background: {{ $user->is_active ? '#2E7D32' : '#DC2626' }}; border-radius: 50%;"></span>
                                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <!-- BOUTON MODIFIER -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       style="width: 32px; height: 32px; background: #E8F5E9; border: none; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; vertical-align: middle;" 
                                       onmouseover="this.style.background='#4CAF50'; this.querySelector('svg').style.stroke='white'" 
                                       onmouseout="this.style.background='#E8F5E9'; this.querySelector('svg').style.stroke='#4CAF50'" 
                                       title="Modifier">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4CAF50" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>

                                    <!-- BOUTON SUPPRIMER -->
                                    @if($user->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="width: 32px; height: 32px; background: #FFEBEE; border: none; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; vertical-align: middle; margin-left: 0.3rem;" onmouseover="this.style.background='#F44336'; this.querySelector('svg').style.stroke='white'" onmouseout="this.style.background='#FFEBEE'; this.querySelector('svg').style.stroke='#F44336'" title="Supprimer">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F44336" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 3rem; text-align: center; color: #94a3b8;">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1rem; opacity: 0.5;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                                    <p style="font-size: 1.1rem; font-weight: 500;">Aucun utilisateur trouvé</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection